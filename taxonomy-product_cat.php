<?php
/**
 * The template for displaying product category archive (Inner Catalog)
 *
 * @package torg-vent-brest
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <!-- Breadcrumbs -->
    <section class="bg-gray-50 py-4 border-b border-gray-200">
        <div class="container mx-auto px-4 max-w-[1200px]">
            <nav class="text-sm text-gray-600">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary transition">Главная</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800"><?php single_term_title(); ?></span>
            </nav>
        </div>
    </section>

    <!-- Page Title -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-[1200px]">
            <h1 class="text-4xl font-bold text-center text-gray-800 mb-12"><?php single_term_title(); ?></h1>
            
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php
                if (have_posts()) :
                    $user_id = get_current_user_id();
                    $favorites = get_user_meta($user_id, 'favorite_products', true) ?: [];
                    while (have_posts()) : the_post();
                        // Get product fields
                        $product_code = get_field('product_code');
                        $product_price = get_field('product_price');
                        $product_old_price = get_field('product_old_price');
                        $is_on_sale = get_field('is_on_sale'); // ACF field for sale status
                        
                        // Calculate discount percentage
                        $discount_percent = 0;
                        if ($is_on_sale && $product_old_price && $product_price && $product_old_price > $product_price) {
                            $discount_percent = round((($product_old_price - $product_price) / $product_old_price) * 100);
                        }
                        ?>
                        <!-- Product Card -->
                        <div class="relative bg-white sm:min-h-[460px] sm:min-w-[282px] rounded-lg p-4 shadow-sm hover:shadow-md border border-gray-100 transition flex flex-col relative group">
                            
                            <!-- Sale Badge -->
                            <?php if ($is_on_sale && $discount_percent > 0) : ?>
                                <span class="absolute top-4 left-4 bg-[#FF972F] text-white text-[10px] z-10 w-[70px] h-[23px] flex items-center justify-center">-<?php echo $discount_percent; ?>%</span>
                            <?php elseif ($is_on_sale) : ?>
                                <span class="absolute top-4 left-4 bg-[#FF972F] text-white text-[10px] z-10 w-[70px] h-[23px] flex items-center justify-center">АКЦИЯ</span>
                            <?php endif; ?>
                            
                            <!-- Favorite Icon -->
                            <!-- Favorite Icon -->
                            <?php $is_fav = in_array(get_the_ID(), $favorites); ?>
                            <button class="favorite-btn absolute top-4 right-4 transition z-10 hover:text-red-500 text-gray-300" data-product-id="<?php the_ID(); ?>">
                                <i class="<?php echo $is_fav ? 'fa-solid text-red-500' : 'fa-regular'; ?> fa-heart text-xl"></i>
                            </button>
                            
                            <!-- Product Image -->
                            <a href="<?php the_permalink(); ?>" class="block">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="h-40 flex items-center justify-center mb-4 mt-4 p-2">
                                        <?php the_post_thumbnail('medium', array('class' => 'max-h-full max-w-full object-contain group-hover:scale-105 transition')); ?>
                                    </div>
                                <?php else : ?>
                                    <div class="h-40 flex items-center justify-center mb-8 mt-8 p-4">
                                        <img src="https://placehold.co/200x100/f3f4f6/9ca3af?text=Product" alt="<?php the_title(); ?>" class="max-h-full group-hover:scale-105 transition">
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Product Title -->
                                <h3 class="text-sm sm:text-[16px] font-medium text-gray-800 mb-2 line-clamp-2 min-h-[40px]"><?php the_title(); ?></h3>
                            </a>
                            
                            <!-- Product Code -->
                            <?php if ($product_code) : ?>
                                <div class="text-xs sm:text-[14px] text-gray-500 mb-4">Код товара: <?php echo esc_html($product_code); ?></div>
                            <?php endif; ?>
                            
                            <!-- Price and Button -->
                            <div class="mt-4">
                                <?php if ($product_price) : ?>
                                    <div class="text-[18px] font-bold text-red-500 mb-3"><?php echo esc_html($product_price); ?> руб.</div>
                                <?php endif; ?>
                                
                            </div>
														<button class="absolute bottom-[20px] left-[20px] right-[20px] w-[242px] sm:h-[46px] bg-primary hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition text-sm sm:text-[16px] add-to-cart-btn" data-product-id="<?php echo get_the_ID(); ?>">В КОРЗИНУ
                            </button>
                        </div>
                        <?php
                    endwhile;
                else :
                    ?>
                    <div class="col-span-full text-center text-gray-500 py-12">
                        <p class="text-lg">Товары не найдены в этой категории.</p>
                        <p class="text-sm mt-2">Добавьте товары в WordPress админ-панели.</p>
                    </div>
                    <?php
                endif;
                ?>
            </div>
            
            <!-- Pagination -->
            <?php
            $pagination = paginate_links(array(
                'mid_size' => 2,
                'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
                'type' => 'array',
            ));
            
            if ($pagination) :
                ?>
                <nav class="mt-12 flex justify-center">
                    <ul class="flex items-center gap-2">
                        <?php foreach ($pagination as $page) : ?>
                            <li><?php echo str_replace('page-numbers', 'page-numbers px-4 py-2 rounded border border-gray-300 hover:bg-primary hover:text-white hover:border-primary transition text-sm', $page); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <?php
            endif;
            ?>
        </div>
    </section>

</main><!-- #main -->

<script>
// Handle Favorite Toggle
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.favorite-btn');
    if (!btn) return;
    
    e.preventDefault();
    
    <?php if (!is_user_logged_in()) : ?>
        window.location.href = '<?php echo home_url('/login'); ?>';
        return;
    <?php endif; ?>
    
    // Add animation class
    const icon = btn.querySelector('i');
    icon.classList.add('scale-125');
    setTimeout(() => icon.classList.remove('scale-125'), 200);
    
    const productId = btn.getAttribute('data-product-id');
    const formData = new FormData();
    formData.append('action', 'toggle_favorite');
    formData.append('product_id', productId);
    formData.append('nonce', '<?php echo wp_create_nonce('favorite_nonce'); ?>');
    
    // Optimistic UI update
    if (icon.classList.contains('fa-solid')) {
        icon.classList.remove('fa-solid', 'text-red-500');
        icon.classList.add('fa-regular', 'text-gray-300');
    } else {
        icon.classList.remove('fa-regular', 'text-gray-300'); // Remove gray if present
        icon.classList.add('fa-solid', 'text-red-500');
    }
    
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            // Revert changes on error
            console.error(data.data.message);
            // Revert logic here if needed
        }
    })
    .catch(error => console.error('Error:', error));
});

// Handle Add to Cart
document.addEventListener('click', function(e) {
    if (!e.target.classList.contains('add-to-cart-btn')) return;
    
    e.preventDefault();
    const btn = e.target;
    
    <?php if (!is_user_logged_in()) : ?>
        window.location.href = '<?php echo home_url('/login'); ?>';
        return;
    <?php endif; ?>
    
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
            btn.classList.remove('bg-primary', 'hover:bg-blue-700');
            btn.classList.add('bg-green-600', 'hover:bg-green-700');
            
            // Update header count
            const headerCount = document.querySelector('.header-cart-count');
            if (headerCount) headerCount.textContent = data.data.cart_count;
            
            // Revert button after 2 seconds
            setTimeout(() => {
                btn.innerText = originalText;
                btn.classList.add('bg-primary', 'hover:bg-blue-700');
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
