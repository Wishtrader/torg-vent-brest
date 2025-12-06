<?php
/**
 * Template Name: Account Page
 * 
 * @package torg-vent-brest
 */

// Redirect if not logged in
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

get_header();

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$first_name = get_user_meta($user_id, 'first_name', true);
$last_name = get_user_meta($user_id, 'last_name', true);
$phone = get_user_meta($user_id, 'phone', true);
$street = get_user_meta($user_id, 'street', true);
$house = get_user_meta($user_id, 'house', true);
$entrance = get_user_meta($user_id, 'entrance', true);
?>

<main id="primary" class="site-main">
    <section class="py-16 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-[1200px]">
            
            <!-- Breadcrumbs -->
            <div class="mb-8 text-sm text-gray-600">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary">Главная</a>
                <span class="mx-2">/</span>
                <a href="<?php echo home_url('/account'); ?>" class="hover:text-primary">Личный кабинет</a>
                <span class="mx-2">/</span>
                <span class="text-primary" id="current-tab-breadcrumb">Учетная запись</span>
            </div>

            <!-- Page Title -->
            <h1 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-8">
                Личный кабинет
            </h1>

            <!-- Tabs -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <!-- Tab Headers -->
                <div class="flex border-b border-gray-200">
                    <button 
                        class="tab-button flex-1 px-6 py-4 text-center font-medium transition border-b-2 border-transparent hover:text-primary active"
                        data-tab="account"
                    >
                        Учетная запись
                    </button>
                    <button 
                        class="tab-button flex-1 px-6 py-4 text-center font-medium transition border-b-2 border-transparent hover:text-primary text-gray-600"
                        data-tab="orders"
                    >
                        История заказов
                    </button>
                    <button 
                        class="tab-button flex-1 px-6 py-4 text-center font-medium transition border-b-2 border-transparent hover:text-primary text-gray-600"
                        data-tab="favorites"
                    >
                        Избранное
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="p-8 md:p-12">
                    
                    <!-- Account Tab -->
                    <div id="account-tab" class="tab-content">
                        <form id="account-form" class="space-y-8">
                            
                            <!-- Contact Person Section -->
                            <div>
                                <h2 class="text-xl font-bold text-gray-800 mb-6">Контактное лицо</h2>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Last Name -->
                                    <div>
                                        <label for="last_name" class="block text-sm text-gray-700 mb-2">
                                            Фамилия*
                                        </label>
                                        <input 
                                            type="text" 
                                            id="last_name" 
                                            name="last_name" 
                                            value="<?php echo esc_attr($last_name); ?>"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                                        >
                                    </div>

                                    <!-- First Name -->
                                    <div>
                                        <label for="first_name" class="block text-sm text-gray-700 mb-2">
                                            Имя*
                                        </label>
                                        <input 
                                            type="text" 
                                            id="first_name" 
                                            name="first_name" 
                                            value="<?php echo esc_attr($first_name); ?>"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                                        >
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm text-gray-700 mb-2">
                                            E-mail*
                                        </label>
                                        <input 
                                            type="email" 
                                            id="email" 
                                            name="email" 
                                            value="<?php echo esc_attr($current_user->user_email); ?>"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                                        >
                                        <p class="text-xs text-gray-500 mt-1">Является логином для входа на сайт</p>
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label for="phone" class="block text-sm text-gray-700 mb-2">
                                            Телефон*
                                        </label>
                                        <input 
                                            type="tel" 
                                            id="phone" 
                                            name="phone" 
                                            value="<?php echo esc_attr($phone); ?>"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Address Section -->
                            <div>
                                <h2 class="text-xl font-bold text-gray-800 mb-6">Адрес доставки</h2>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Street -->
                                    <div>
                                        <label for="street" class="block text-sm text-gray-700 mb-2">
                                            Улица
                                        </label>
                                        <input 
                                            type="text" 
                                            id="street" 
                                            name="street" 
                                            value="<?php echo esc_attr($street); ?>"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                                        >
                                    </div>

                                    <!-- House -->
                                    <div>
                                        <label for="house" class="block text-sm text-gray-700 mb-2">
                                            Дом
                                        </label>
                                        <input 
                                            type="text" 
                                            id="house" 
                                            name="house" 
                                            value="<?php echo esc_attr($house); ?>"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                                        >
                                    </div>

                                    <!-- Entrance -->
                                    <div>
                                        <label for="entrance" class="block text-sm text-gray-700 mb-2">
                                            Подъезд
                                        </label>
                                        <input 
                                            type="text" 
                                            id="entrance" 
                                            name="entrance" 
                                            value="<?php echo esc_attr($entrance); ?>"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div>
                                <h2 class="text-xl font-bold text-gray-800 mb-6">Пароль</h2>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- New Password -->
                                    <div class="relative">
                                        <label for="password" class="block text-sm text-gray-700 mb-2">
                                            Пароль
                                        </label>
                                        <input 
                                            type="password" 
                                            id="password" 
                                            name="password" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition pr-12"
                                            placeholder="••••••••"
                                        >
                                        <button 
                                            type="button" 
                                            onclick="togglePasswordVisibility('password', 'password-eye')"
                                            class="absolute right-4 top-[42px] text-gray-400 hover:text-gray-600 transition"
                                        >
                                            <i class="fa-regular fa-eye" id="password-eye"></i>
                                        </button>
                                        <p class="text-xs text-gray-500 mt-1">Длина не менее 8 символов</p>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="relative">
                                        <label for="password_confirm" class="block text-sm text-gray-700 mb-2">
                                            Подтвердите пароль
                                        </label>
                                        <input 
                                            type="password" 
                                            id="password_confirm" 
                                            name="password_confirm" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition pr-12"
                                            placeholder="••••••••"
                                        >
                                        <button 
                                            type="button" 
                                            onclick="togglePasswordVisibility('password_confirm', 'password-confirm-eye')"
                                            class="absolute right-4 top-[42px] text-gray-400 hover:text-gray-600 transition"
                                        >
                                            <i class="fa-regular fa-eye" id="password-confirm-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button 
                                    type="submit" 
                                    class="bg-white border-2 border-gray-300 hover:border-primary hover:text-primary text-gray-700 font-bold py-3 px-8 rounded transition uppercase text-sm"
                                >
                                    Сохранить изменения
                                </button>
                            </div>

                            <!-- Messages -->
                            <div id="account-message" class="hidden"></div>
                        </form>
                    </div>

                    <!-- Orders Tab -->
                    <div id="orders-tab" class="tab-content hidden">
                        <div class="text-center py-12">
                            <i class="fa-solid fa-box-open text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">У вас пока нет заказов</h3>
                            <p class="text-gray-600 mb-6">Начните делать покупки в нашем каталоге</p>
                            <a href="<?php echo home_url('/catalog'); ?>" class="main-button text-white font-bold py-3 px-8 rounded transition shadow-lg shadow-blue-500/30 text-sm uppercase inline-block">
                                Перейти в каталог
                            </a>
                        </div>
                    </div>

                    <!-- Favorites Tab -->
                    <div id="favorites-tab" class="tab-content hidden">
                        <?php
                        $user_id = get_current_user_id();
                        $favorites = get_user_meta($user_id, 'favorite_products', true);
                        
                        if (!empty($favorites) && is_array($favorites)) :
                            $favorites_query = new WP_Query(array(
                                'post_type' => 'product',
                                'post__in' => $favorites,
                                'posts_per_page' => -1
                            ));
                            
                            if ($favorites_query->have_posts()) :
                                ?>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                    <?php
                                    while ($favorites_query->have_posts()) : $favorites_query->the_post();
                                        $product_id = get_the_ID();
                                        $price = get_field('price');
                                        $is_new = get_field('is_new');
                                        $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                        ?>
                                        <div class="bg-white rounded-lg border border-gray-100 hover:shadow-lg transition group relative p-4 product-card" id="fav-product-<?php echo $product_id; ?>">
                                            <?php if ($is_new) : ?>
                                                <span class="absolute top-4 left-4 bg-red-600 text-white text-[10px] font-bold px-2 py-1 uppercase">Новинка</span>
                                            <?php endif; ?>
                                            
                                            <button class="favorite-btn absolute top-4 right-4 text-gray-300 hover:text-red-500 transition z-10" data-product-id="<?php echo $product_id; ?>">
                                                <i class="fa-solid fa-heart text-xl text-red-500"></i>
                                            </button>
                                            
                                            <div class="mb-4 aspect-[4/3] flex items-center justify-center">
                                                <img src="<?php echo $image ? esc_url($image) : 'https://placehold.co/300x200?text=No+Image'; ?>" alt="<?php the_title(); ?>" class="max-w-full max-h-full object-contain">
                                            </div>
                                            
                                            <h3 class="font-medium text-gray-800 mb-2 text-sm h-[40px] overflow-hidden">
                                                <a href="<?php the_permalink(); ?>" class="hover:text-primary transition">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>
                                            
                                            <div class="text-xs text-gray-500 mb-3">Код товара: <?php echo $product_id; ?></div>
                                            
                                            <div class="font-bold text-red-600 text-lg mb-4">
                                                <?php echo number_format((float)$price, 2, '.', ' '); ?> руб
                                            </div>
                                            
                                            <button class="w-full bg-[#1864C8] hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded text-xs uppercase transition add-to-cart-btn" data-product-id="<?php echo $product_id; ?>">
                                                В корзину
                                            </button>
                                        </div>
                                    <?php endwhile; wp_reset_postdata(); ?>
                                </div>
                            <?php else : ?>
                                <div class="text-center py-12">
                                    <i class="fa-regular fa-heart text-6xl text-gray-300 mb-4"></i>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">Избранные товары не найдены</h3>
                                    <p class="text-gray-600 mb-6">Возможно, товары были удалены</p>
                                    <a href="<?php echo home_url('/catalog'); ?>" class="main-button text-white font-bold py-3 px-8 rounded transition shadow-lg shadow-blue-500/30 text-sm uppercase inline-block">
                                        Перейти в каталог
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="text-center py-12">
                                <i class="fa-regular fa-heart text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">У вас пока нет избранных товаров</h3>
                                <p class="text-gray-600 mb-6">Добавляйте товары в избранное, чтобы не потерять их</p>
                                <a href="<?php echo home_url('/catalog'); ?>" class="main-button text-white font-bold py-3 px-8 rounded transition shadow-lg shadow-blue-500/30 text-sm uppercase inline-block">
                                    Перейти в каталог
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

<script>
// Tab switching
document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', function() {
        const tabName = this.getAttribute('data-tab');
        
        // Remove active class from all buttons
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'border-primary', 'text-primary');
            btn.classList.add('text-gray-600');
        });
        
        // Add active class to clicked button
        this.classList.add('active', 'border-primary', 'text-primary');
        this.classList.remove('text-gray-600');
        
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Show selected tab content
        document.getElementById(tabName + '-tab').classList.remove('hidden');

        // Update breadcrumbs
        const tabText = this.innerText.trim();
        document.getElementById('current-tab-breadcrumb').textContent = tabText;
    });
});

// Password visibility toggle
function togglePasswordVisibility(inputId, iconId) {
    const passwordField = document.getElementById(inputId);
    const eyeIcon = document.getElementById(iconId);
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

// Handle form submission
document.getElementById('account-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageDiv = document.getElementById('account-message');
    const formData = new FormData(this);
    formData.append('action', 'update_user_account');
    formData.append('nonce', '<?php echo wp_create_nonce('update_account_nonce'); ?>');
    
    // Validate passwords match if provided
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirm').value;
    
    if (password && password !== passwordConfirm) {
        messageDiv.className = 'p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
        messageDiv.textContent = 'Пароли не совпадают';
        messageDiv.classList.remove('hidden');
        return;
    }
    
    if (password && password.length < 8) {
        messageDiv.className = 'p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
        messageDiv.textContent = 'Пароль должен содержать минимум 8 символов';
        messageDiv.classList.remove('hidden');
        return;
    }
    
    // Show loading state
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.textContent = 'Сохранение...';
    submitButton.disabled = true;
    
    // Send AJAX request
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageDiv.className = 'p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg';
            messageDiv.textContent = data.data.message || 'Изменения сохранены успешно!';
            messageDiv.classList.remove('hidden');
            
            // Clear password fields
            document.getElementById('password').value = '';
            document.getElementById('password_confirm').value = '';
        } else {
            messageDiv.className = 'p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
            messageDiv.textContent = data.data.message || 'Произошла ошибка при сохранении';
            messageDiv.classList.remove('hidden');
        }
        
        // Reset button
        submitButton.textContent = originalText;
        submitButton.disabled = false;
        
        // Scroll to message
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    })
    .catch(error => {
        console.error('Error:', error);
        messageDiv.className = 'p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
        messageDiv.textContent = 'Произошла ошибка. Попробуйте еще раз.';
        messageDiv.classList.remove('hidden');
        
        // Reset button
        submitButton.textContent = originalText;
        submitButton.disabled = false;
    });
});

// Handle Favorite Toggle
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.favorite-btn');
    if (!btn) return;
    
    e.preventDefault();
    
    // Add animation class
    const icon = btn.querySelector('i');
    icon.classList.add('scale-125');
    setTimeout(() => icon.classList.remove('scale-125'), 200);
    
    const productId = btn.getAttribute('data-product-id');
    const formData = new FormData();
    formData.append('action', 'toggle_favorite');
    formData.append('product_id', productId);
    formData.append('nonce', '<?php echo wp_create_nonce('favorite_nonce'); ?>');
    
    // Optimistic UI update for catalog
    if (!document.getElementById('favorites-tab') || document.getElementById('favorites-tab').classList.contains('hidden')) {
        if (icon.classList.contains('fa-solid')) {
            icon.classList.remove('fa-solid', 'text-red-500');
            icon.classList.add('fa-regular', 'text-gray-300');
        } else {
            icon.classList.remove('fa-regular', 'text-gray-300');
            icon.classList.add('fa-solid', 'text-red-500');
        }
    }
    
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Handle specific logic for Favorites Tab (Personal Account)
            const favoritesTab = document.getElementById('favorites-tab');
            if (favoritesTab && !favoritesTab.classList.contains('hidden')) {
                if (data.data.action === 'removed') {
                    // Remove item card if we are in the favorites tab
                    const card = document.getElementById('fav-product-' + productId);
                    if (card) {
                        card.remove();
                        
                        // Check if empty
                        const remainingCards = favoritesTab.querySelectorAll('.product-card');
                        if (remainingCards.length === 0) {
                            location.reload(); // Reload to show empty state
                        }
                    }
                }
            }
        } else {
            // Revert changes on error
            console.error(data.data.message);
            // Revert icon state logic if needed
        }
    })
    .catch(error => console.error('Error:', error));
});

// Handle Add to Cart
document.addEventListener('click', function(e) {
    if (!e.target.classList.contains('add-to-cart-btn')) return;
    
    e.preventDefault();
    const btn = e.target;
    
    // Check login handled by server response or page logic
    
    const originalText = btn.innerText;
    btn.innerText = 'Добавление...';
    btn.disabled = true;
    
    const productId = btn.getAttribute('data-product-id');
    const formData = new FormData();
    formData.append('action', 'add_to_cart');
    formData.append('product_id', productId);
    formData.append('quantity', 1);
    formData.append('nonce', '<?php echo wp_create_nonce('cart_nonce'); ?>');
    
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            btn.innerText = 'В КОРЗИНЕ';
            btn.classList.remove('bg-[#1864C8]', 'hover:bg-blue-700');
            btn.classList.add('bg-green-600', 'hover:bg-green-700');
            
            // Update header count
            const headerCount = document.querySelector('.header-cart-count');
            if (headerCount) headerCount.textContent = data.data.cart_count;
            
            // Revert button after 2 seconds
            setTimeout(() => {
                btn.innerText = originalText;
                btn.classList.add('bg-[#1864C8]', 'hover:bg-blue-700');
                btn.classList.remove('bg-green-600', 'hover:bg-green-700');
                btn.disabled = false;
            }, 2000);
        } else {
            alert(data.data.message);
            btn.innerText = originalText;
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.innerText = originalText;
        btn.disabled = false;
    });
});
</script>

<?php
get_footer();
