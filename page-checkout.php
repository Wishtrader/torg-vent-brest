<?php
/**
 * Template Name: Checkout Page
 * 
 * @package torg-vent-brest
 */

// Handles redirects for non-logged in users or empty carts
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

$user_id = get_current_user_id();
$cart = get_user_meta($user_id, 'cart_items', true);

if (empty($cart) || !is_array($cart)) {
    wp_redirect(home_url('/cart'));
    exit;
}

get_header();

// Get Pre-fill Data
$first_name = get_user_meta($user_id, 'first_name', true);
$last_name = get_user_meta($user_id, 'last_name', true);
$phone = get_user_meta($user_id, 'phone', true);
$street = get_user_meta($user_id, 'street', true);
$house = get_user_meta($user_id, 'house', true);
$entrance = get_user_meta($user_id, 'entrance', true);

$totals = calculate_cart_totals($user_id);
?>

<main id="primary" class="site-main">
    <section class="py-12 min-h-screen">
        <div class="container mx-auto px-4 max-w-[1200px]">
            
            <h1 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">
                Оформление заказа
            </h1>

            <form id="checkout-form" class="flex flex-col lg:flex-row gap-8">
                
                <!-- Left Column: Form Fields -->
                <div class="flex-grow bg-white rounded-lg p-8 shadow-sm border border-gray-200">
                    
                    <!-- Contact Person -->
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-gray-800 mb-6">Контактное лицо</h2>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
                                <label for="last_name" class="text-gray-600 md:text-left">Фамилия<span class="text-red-500">*</span></label>
                                <div class="md:col-span-3">
                                    <input type="text" id="last_name" name="last_name" value="<?php echo esc_attr($last_name); ?>" required class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-primary">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
                                <label for="first_name" class="text-gray-600 md:text-left">Имя<span class="text-red-500">*</span></label>
                                <div class="md:col-span-3">
                                    <input type="text" id="first_name" name="first_name" value="<?php echo esc_attr($first_name); ?>" required class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-primary">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
                                <label for="phone" class="text-gray-600 md:text-left">Телефон<span class="text-red-500">*</span></label>
                                <div class="md:col-span-3">
                                    <input type="tel" id="phone" name="phone" value="<?php echo esc_attr($phone); ?>" required class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-primary">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Method -->
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-gray-800 mb-6">Доставка</h2>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="radio" id="delivery_entrance" name="delivery_method" value="delivery" checked class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                <label for="delivery_entrance" class="ml-3 text-gray-700">Доставка до подъезда</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="delivery_pickup" name="delivery_method" value="pickup" class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                <label for="delivery_pickup" class="ml-3 text-gray-700">Самовывоз (адрес склада)</label>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Address (Conditional) -->
                    <div id="delivery-address-section" class="mb-8 transition-all duration-300 overflow-hidden">
                        <h2 class="text-lg font-bold text-gray-800 mb-6">Адрес доставки</h2>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
                                <label for="street" class="text-gray-600 md:text-left">Улица<span class="text-red-500">*</span></label>
                                <div class="md:col-span-3">
                                    <input type="text" id="street" name="street" value="<?php echo esc_attr($street); ?>" required class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-primary">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
                                <label for="house" class="text-gray-600 md:text-left">Дом<span class="text-red-500">*</span></label>
                                <div class="md:col-span-3">
                                    <input type="text" id="house" name="house" value="<?php echo esc_attr($house); ?>" required class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-primary">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
                                <label for="entrance" class="text-gray-600 md:text-left">Подъезд</label>
                                <div class="md:col-span-3">
                                    <input type="text" id="entrance" name="entrance" value="<?php echo esc_attr($entrance); ?>" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-primary">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-gray-800 mb-6">Оплата</h2>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="radio" id="payment_office" name="payment_method" value="office" class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                <label for="payment_office" class="ml-3 text-gray-700">В офисе компании</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="payment_receipt" name="payment_method" value="receipt" class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                <label for="payment_receipt" class="ml-3 text-gray-700">При получении</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="payment_erip" name="payment_method" value="erip" checked class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                <label for="payment_erip" class="ml-3 text-gray-700">Через ЕРИП</label>
                            </div>
                        </div>
                    </div>

                    <!-- Order Comment -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-6">Комментарий к заказу</h2>
                        <textarea name="order_comment" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-primary"></textarea>
                    </div>

                    <div id="checkout-message" class="mt-6 hidden"></div>

                    <div class="mt-4 text-xs text-gray-500">
                        * поля, обязательные для заполнения
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="w-full lg:w-[380px] flex-shrink-0">
                    <div class="bg-white rounded-lg p-8 shadow-sm border border-gray-200 sticky top-24">
                        
                        <div class="flex justify-between mb-4 text-gray-600">
                            <span>Товаров, <?php echo $totals['count']; ?> шт</span>
                            <span class="font-medium text-gray-800"><?php echo $totals['total']; ?> BYN</span>
                        </div>
                        
                        <?php if ($totals['discount'] != '0.00') : ?>
                            <div class="flex justify-between mb-8 text-red-500">
                                <span>Скидка</span>
                                <span class="font-medium"><?php echo $totals['discount']; ?> BYN</span>
                            </div>
                        <?php endif; ?>

                        <div class="flex justify-between items-center mb-8 pt-4 border-t border-gray-100">
                            <span class="text-xl font-bold text-gray-800 uppercase">Итого</span>
                            <span class="text-2xl font-bold text-red-600"><?php echo $totals['final']; ?> BYN</span>
                        </div>

                        <button type="submit" class="w-full bg-[#5C9CE6] hover:bg-blue-600 text-white font-bold py-4 rounded shadow-lg shadow-blue-500/30 transition uppercase tracking-wide">
                            Оформить заказ
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </section>
</main>

<script>
// Toggle Address Section
const deliveryRadios = document.getElementsByName('delivery_method');
const addressSection = document.getElementById('delivery-address-section');
const streetInput = document.getElementById('street');
const houseInput = document.getElementById('house');

function toggleAddress() {
    let selected;
    for (const radio of deliveryRadios) {
        if (radio.checked) {
            selected = radio.value;
            break;
        }
    }

    if (selected === 'pickup') {
        addressSection.style.display = 'none';
        streetInput.required = false;
        houseInput.required = false;
    } else {
        addressSection.style.display = 'block';
        streetInput.required = true;
        houseInput.required = true;
    }
}

for (const radio of deliveryRadios) {
    radio.addEventListener('change', toggleAddress);
}

// Initial check
toggleAddress();

// Handle Form Submission
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    const messageDiv = document.getElementById('checkout-message');
    
    submitBtn.textContent = 'Обработка...';
    submitBtn.disabled = true;
    messageDiv.classList.add('hidden');
    
    const formData = new FormData(this);
    formData.append('action', 'place_order');
    formData.append('nonce', '<?php echo wp_create_nonce('checkout_nonce'); ?>');
    
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            submitBtn.textContent = 'Успешно!';
            submitBtn.classList.remove('bg-[#5C9CE6]', 'hover:bg-blue-600');
            submitBtn.classList.add('bg-green-600');
            
            messageDiv.className = 'mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg';
            messageDiv.textContent = data.data.message;
            messageDiv.classList.remove('hidden');
            
            // Redirect
            setTimeout(() => {
                window.location.href = data.data.redirect_url;
            }, 2000);
        } else {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
            
            messageDiv.className = 'mt-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
            messageDiv.textContent = data.data.message || 'Произошла ошибка';
            messageDiv.classList.remove('hidden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        messageDiv.className = 'mt-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
        messageDiv.textContent = 'Ошибка сети. Попробуйте позже.';
        messageDiv.classList.remove('hidden');
    });
});
</script>

<?php
get_footer();
