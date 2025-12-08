<?php
/**
 * Template Name: Shopping Cart
 * 
 * @package torg-vent-brest
 */

// Handle non-logged in users
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

get_header();

$user_id = get_current_user_id();
$cart = get_user_meta($user_id, 'cart_items', true);
$has_items = !empty($cart) && is_array($cart);
$totals = calculate_cart_totals($user_id);
?>

<main id="primary" class="site-main">
    <section class="py-12 min-h-screen">
        <div class="container mx-auto px-4 max-w-[1200px]">
            
            <!-- Breadcrumbs -->
            <div class="mb-12 text-sm text-gray-600">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary">Главная</a>
                <span class="mx-2">/</span>
                <span class="text-primary">Корзина</span>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">
                Корзина
            </h1>

            <?php if ($has_items) : ?>
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <!-- Cart Items List -->
                    <div class="flex-grow space-y-4">
                        <?php
                        foreach ($cart as $product_id => $quantity) :
                            // Get product data
                            $title = get_the_title($product_id);
                            $image = get_the_post_thumbnail_url($product_id, 'medium');
                            $code = get_field('product_code', $product_id);
                            $price = floatval(get_field('product_price', $product_id));
                            $old_price = floatval(get_field('product_old_price', $product_id));
                            
                            // Determine actual price and old price display
                            $display_price = $price;
                            $display_old_price = ($old_price > $price) ? $old_price : 0;
                            ?>
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 flex flex-col md:flex-row items-center gap-6 relative cart-item" data-product-id="<?php echo $product_id; ?>">
                                
                                <!-- Delete Button -->
                                <button class="absolute top-4 right-4 text-gray-300 hover:text-red-500 transition remove-item-btn" title="Удалить товар">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>

                                <!-- Image -->
                                <div class="w-full md:w-[120px] h-[120px] flex-shrink-0 flex items-center justify-center bg-gray-50 rounded p-2">
                                    <img src="<?php echo $image ? esc_url($image) : 'https://placehold.co/120x80?text=No+Image'; ?>" alt="<?php echo esc_attr($title); ?>" class="max-w-full max-h-full object-contain">
                                </div>

                                <!-- Info -->
                                <div class="flex-grow text-center md:text-left">
                                    <h3 class="font-medium text-gray-800 mb-2">
                                        <a href="<?php echo get_permalink($product_id); ?>" class="hover:text-primary transition">
                                            <?php echo esc_html($title); ?>
                                        </a>
                                    </h3>
                                    <?php if ($code) : ?>
                                        <div class="text-xs text-gray-500">Код товара: <?php echo esc_html($code); ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Quantity -->
                                <div class="flex items-center border border-gray-200 rounded">
                                    <button class="px-3 py-1 text-gray-500 hover:bg-gray-100 transition minus-btn">-</button>
                                    <input type="text" value="<?php echo esc_attr($quantity); ?>" class="w-12 text-center py-1 outline-none text-gray-700 bg-transparent qty-input" readonly>
                                    <button class="px-3 py-1 text-gray-500 hover:bg-gray-100 transition plus-btn">+</button>
                                </div>

                                <!-- Price -->
                                <div class="text-right min-w-[120px]">
                                    <div class="text-xl font-bold text-red-600">
                                        <?php echo number_format($display_price, 2, '.', ' '); ?> руб
                                    </div>
                                    <?php if ($display_old_price > 0) : ?>
                                        <div class="text-sm text-gray-400 line-through">
                                            <?php echo number_format($display_old_price, 2, '.', ' '); ?> руб
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Order Summary -->
                    <div class="w-full lg:w-[380px] flex-shrink-0">
                        <div class="bg-white rounded-lg p-8 shadow-sm border border-gray-200 sticky top-24">
                            
                            <div class="flex justify-between mb-4 text-gray-600">
                                <span id="summary-count">Товаров, <?php echo $totals['count']; ?> шт</span>
                                <span class="font-medium" id="summary-total"><?php echo $totals['total']; ?> руб</span>
                            </div>
                            
                            <?php if ($totals['discount'] != '0.00') : ?>
                                <div class="flex justify-between mb-8 text-red-500">
                                    <span>Скидка</span>
                                    <span class="font-medium" id="summary-discount"><?php echo $totals['discount']; ?> руб</span>
                                </div>
                            <?php endif; ?>

                            <div class="flex justify-between items-center mb-8 pt-4 border-t border-gray-100">
                                <span class="text-xl font-bold text-gray-800 uppercase">Итого</span>
                                <span class="text-2xl font-bold text-red-600" id="summary-final"><?php echo $totals['final']; ?> руб</span>
                            </div>

                            <a href="<?php echo home_url('/checkout'); ?>" class="block w-full text-center bg-[#5C9CE6] hover:bg-blue-600 text-white font-bold py-4 rounded shadow-lg shadow-blue-500/30 transition uppercase tracking-wide">
                                Оформить заказ
                            </a>
                        </div>
                    </div>

                </div>
            <?php else : ?>
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-sm p-12 text-center max-w-2xl mx-auto">
                    <i class="fa-solid fa-cart-shopping text-6xl text-gray-200 mb-6"></i>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Ваша корзина пуста</h2>
                    <p class="text-gray-500 mb-8">Исправьте это, выбрав товары из нашего каталога</p>
                    <a href="<?php echo home_url('/catalog'); ?>" class="main-button text-white font-bold py-3 px-8 rounded transition shadow-lg shadow-blue-500/30 text-sm uppercase inline-block">
                        Перейти в каталог
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </section>
</main>

<script>
// Quantity Logic
document.querySelectorAll('.cart-item').forEach(item => {
    const productId = item.dataset.productId;
    const input = item.querySelector('.qty-input');
    const minusBtn = item.querySelector('.minus-btn');
    const plusBtn = item.querySelector('.plus-btn');
    const removeBtn = item.querySelector('.remove-item-btn');

    // Debounce function for updates
    let debounceTimer;
    const updateCart = (qty) => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const formData = new FormData();
            formData.append('action', 'update_cart_item');
            formData.append('product_id', productId);
            formData.append('quantity', qty);
            formData.append('nonce', '<?php echo wp_create_nonce('cart_nonce'); ?>');

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update summary
                    document.getElementById('summary-count').textContent = `Товаров, ${data.data.cart_count} шт`;
                    document.getElementById('summary-total').textContent = `${data.data.cart_total} руб`;
                    document.getElementById('summary-final').textContent = `${data.data.cart_final} руб`;
                    
                    if (data.data.cart_discount !== '0.00') {
                        const discountEl = document.getElementById('summary-discount');
                        if (discountEl) discountEl.textContent = `${data.data.cart_discount} руб`;
                    }
                    
                    // Update header if exists
                     const headerCount = document.querySelector('.header-cart-count');
                     if (headerCount) headerCount.textContent = data.data.cart_count;

                    if (qty === 0) {
                        item.remove();
                        if (data.data.cart_count === 0) location.reload();
                    }
                }
            });
        }, 500);
    };

    minusBtn.addEventListener('click', () => {
        let val = parseInt(input.value);
        if (val > 1) {
            val--;
            input.value = val;
            updateCart(val);
        }
    });

    plusBtn.addEventListener('click', () => {
        let val = parseInt(input.value);
        val++;
        input.value = val;
        updateCart(val);
    });

    removeBtn.addEventListener('click', () => {
        if(confirm('Удалить товар из корзины?')) {
            updateCart(0);
        }
    });
});
</script>

<?php
get_footer();
