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
                        $is_new = get_field('is_new'); // ACF field for new product status
                        
                        // Calculate discount percentage
                        $discount_percent = 0;
                        if ($is_on_sale && $product_old_price && $product_price && $product_old_price > $product_price) {
                            $discount_percent = round((($product_old_price - $product_price) / $product_old_price) * 100);
                        }
                        ?>
                        <!-- Product Card -->
                        <div class="relative bg-white sm:min-h-[460px] sm:min-w-[282px] rounded-lg p-4 shadow-sm hover:shadow-md border border-gray-100 transition flex flex-col relative group">
                            
                            <!-- Badge (New takes priority over Sale) -->
                            <?php if ($is_new) : ?>
                                <span class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold z-10 px-3 py-1.5 rounded">НОВИНКА</span>
                            <?php elseif ($is_on_sale && $discount_percent > 0) : ?>
                                <span class="absolute top-4 left-4 bg-[#FF972F] text-white text-[10px] z-10 w-[70px] h-[23px] flex items-center justify-center">-<?php echo $discount_percent; ?>%</span>
                            <?php elseif ($is_on_sale) : ?>
                                <span class="absolute top-4 left-4 bg-[#FF972F] text-white text-[10px] z-10 w-[70px] h-[23px] flex items-center justify-center">АКЦИЯ</span>
                            <?php endif; ?>
                            
                            <!-- Favorite Icon -->
                            <?php $is_fav = in_array(get_the_ID(), $favorites); ?>
                            <button class="favorite-btn absolute top-4 right-4 transition z-10 hover:text-red-500 <?php echo $is_fav ? 'text-red-500' : 'text-gray-300'; ?>" data-product-id="<?php the_ID(); ?>">
                                <i class="<?php echo $is_fav ? 'fa-solid' : 'fa-regular'; ?> fa-heart text-xl"></i>
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
														<button class="absolute bottom-[20px] left-[20px] right-[20px] h-[44px] sm:h-[46px] bg-primary hover:bg-blue-700 text-white font-medium rounded transition text-sm sm:text-[16px] add-to-cart-btn flex items-center justify-center" data-product-id="<?php echo get_the_ID(); ?>">В КОРЗИНУ
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

    <!-- SEO Text Section -->
    <section class="py-12 bg-white border-t border-gray-200">
        <div class="container mx-auto px-4 max-w-[1240px]">
             <div class="prose max-w-none text-gray-700 text-sm md:text-base leading-relaxed">
                <?php 
                // Display category description
                $term_description = term_description(); 
                if (! empty($term_description)) {
                    echo $term_description;
                } elseif (current_user_can('edit_themes')) {
                    // Hint for admin
                    echo '<p class="text-gray-400 italic border-l-4 border-yellow-400 pl-4 py-2 bg-yellow-50">Описание категории отсутствует. Добавьте его в админ-панели (Товары -> Категории), чтобы текст появился здесь.</p>';
                }
                ?>
             </div>
        </div>
    </section>

    <!-- Recommended Products Section -->
    <section class="py-16 bg-gray-50 border-t border-gray-200">
        <div class="container mx-auto px-4 max-w-[1240px]">
            <h2 class="text-[24px] md:text-[36px] font-bold text-center text-gray-800 mb-12">Рекомендуемые товары</h2>
             <?php
            // Query for popular products
            $popular_query = new WP_Query(array(
                'post_type' => 'product',
                'posts_per_page' => 8,
                'meta_key' => 'is_popular',
                'meta_value' => '1',
            ));
            
            if ($popular_query->have_posts()) :
            ?>
            <div class="relative px-0">
                <!-- Navigation Arrows -->
                 <button id="rec-prev" class="absolute top-1/2 left-0 lg:-left-4 transform -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-[#1E65C6] text-white flex items-center justify-center shadow-lg hover:bg-blue-700 transition opacity-50 cursor-not-allowed hidden md:flex" disabled>
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button id="rec-next" class="absolute top-1/2 right-0 lg:-right-4 transform -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-[#1E65C6] text-white flex items-center justify-center shadow-lg hover:bg-blue-700 transition hidden md:flex">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

                <!-- Carousel Container -->
                <div class="overflow-hidden">
                    <div id="rec-slider" class="flex transition-transform duration-500 ease-in-out gap-6">
                        <?php while ($popular_query->have_posts()) : $popular_query->the_post(); 
                             $rec_id = get_the_ID();
                             $rec_price = get_field('product_price');
                             $rec_old_price = get_field('product_old_price');
                             $rec_code = get_field('product_code');
                             $rec_is_new = get_field('is_new');
                             $rec_is_sale = get_field('is_on_sale');
                             
                             // Favorites check for this loop
                             $cur_user_id = get_current_user_id();
                             $rec_favorites = $cur_user_id ? get_user_meta($cur_user_id, 'favorite_products', true) : [];
                             if(!is_array($rec_favorites)) $rec_favorites = [];
                             $rec_is_fav = in_array($rec_id, $rec_favorites);
                             
                             // Discount calc
                             $rec_discount = 0;
                             if ($rec_is_sale && $rec_old_price && $rec_price && $rec_old_price > $rec_price) {
                                 $rec_discount = round((($rec_old_price - $rec_price) / $rec_old_price) * 100);
                             }
                             
                             // Image logic
                             $rec_img = get_the_post_thumbnail_url($rec_id, 'medium');
                             if(!$rec_img) {
                                 $custom_img = get_field('product_custom_image');
                                 $rec_img = $custom_img ? $custom_img['url'] : 'https://placehold.co/200x200/f3f4f6/9ca3af?text=Product';
                             }
                        ?>
                        <!-- Carousel Item -->
                        <!-- Widths: Mobile 100%, Tablet 50%, Desktop 25%. Minus gap adjustment -->
                        <div class="rec-item flex-shrink-0 w-full sm:w-[calc(50%-12px)] lg:w-[calc(25%-18px)] snap-start"> 
                            <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md border border-gray-100 transition flex flex-col relative h-full group">
                                <!-- Badges -->
                                <?php if ($rec_is_new) : ?>
                                    <span class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold z-10 px-3 py-1.5 rounded">НОВИНКА</span>
                                <?php elseif ($rec_is_sale) : ?>
                                    <span class="absolute top-4 left-4 bg-[#FF972F] text-white text-[10px] font-bold z-10 px-2 py-1 rounded">
                                        <?php echo $rec_discount > 0 ? "-{$rec_discount}%" : "АКЦИЯ"; ?>
                                    </span>
                                <?php endif; ?>
                                
                                <!-- Favorite Btn -->
                                <button class="favorite-btn absolute top-4 right-4 transition z-10 hover:text-red-500 <?php echo $rec_is_fav ? 'text-red-500' : 'text-gray-300'; ?>" data-product-id="<?php echo $rec_id; ?>">
                                    <i class="<?php echo $rec_is_fav ? 'fa-solid' : 'fa-regular'; ?> fa-heart text-xl"></i>
                                </button>
                                
                                <!-- Image -->
                                <a href="<?php the_permalink(); ?>" class="block h-40 flex items-center justify-center mb-4 p-2 overflow-hidden">
                                    <img src="<?php echo esc_url($rec_img); ?>" alt="<?php the_title_attribute(); ?>" class="max-h-full object-contain group-hover:scale-105 transition duration-300">
                                </a>
                                
                                <!-- Title -->
                                <a href="<?php the_permalink(); ?>" class="block flex-grow">
                                     <h3 class="text-sm font-medium text-gray-800 mb-2 line-clamp-2 min-h-[40px] hover:text-[#1E65C6] transition"><?php the_title(); ?></h3>
                                </a>
                                
                                <!-- Code -->
                                <div class="text-xs text-gray-500 mb-4">
                                    <?php echo $rec_code ? "Код товара: " . esc_html($rec_code) : "&nbsp;"; ?>
                                </div>
                                
                                <!-- Price & Button -->
                                <div class="mt-auto">
                                    <div class="text-lg font-bold text-red-500 mb-3">
                                        <?php echo $rec_price ? number_format($rec_price, 2, '.', ' ') . ' руб.' : 'Цена по запросу'; ?>
                                    </div>
                                    <button class="w-full bg-[#1E65C6] hover:bg-[#154b96] text-white font-bold py-2.5 rounded transition text-sm uppercase tracking-wide add-to-cart-btn flex items-center justify-center h-[42px]" data-product-id="<?php echo $rec_id; ?>">
                                        В КОРЗИНУ
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
            
            <!-- Slider Script -->
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const slider = document.getElementById('rec-slider');
                const prevBtn = document.getElementById('rec-prev');
                const nextBtn = document.getElementById('rec-next');
                const items = slider ? slider.querySelectorAll('.rec-item') : [];
                const totalItems = items.length;
                
                if(totalItems === 0) return;

                let currentIndex = 0;
                let visibleItems = 4;
                let maxIndex = 0;

                function updateConfig() {
                    const w = window.innerWidth;
                    if (w >= 1024) visibleItems = 4; // LG
                    else if (w >= 640) visibleItems = 2; // SM
                    else visibleItems = 1; // Mobile

                    maxIndex = Math.max(0, totalItems - visibleItems);
                    
                    if (currentIndex > maxIndex) currentIndex = maxIndex;
                    updateSlider();
                }
                
                function updateSlider() {
                    // Gap is 24px (gap-6)
                    const itemWidth = items[0].offsetWidth;
                    const gap = 24; 
                    const offset = currentIndex * (itemWidth + gap);
                    
                    slider.style.transform = `translateX(-${offset}px)`;
                    
                    if(prevBtn) {
                        if(currentIndex === 0) {
                             prevBtn.disabled = true;
                             prevBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        } else {
                             prevBtn.disabled = false;
                             prevBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        }
                    }
                    
                    if(nextBtn) {
                        if(currentIndex >= maxIndex) {
                             nextBtn.disabled = true;
                             nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        } else {
                             nextBtn.disabled = false;
                             nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        }
                    }
                }
                
                if (nextBtn) {
                    nextBtn.addEventListener('click', function() {
                        if (currentIndex < maxIndex) {
                            currentIndex++;
                            updateSlider();
                        }
                    });
                }
                
                if (prevBtn) {
                    prevBtn.addEventListener('click', function() {
                        if (currentIndex > 0) {
                            currentIndex--;
                            updateSlider();
                        }
                    });
                }
                
                // Swipe
                let touchStartX = 0;
                let touchEndX = 0;
                
                slider.addEventListener('touchstart', e => {
                    touchStartX = e.changedTouches[0].screenX;
                });
                
                slider.addEventListener('touchend', e => {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                });
                
                function handleSwipe() {
                    if (touchEndX < touchStartX - 50) {
                        if (currentIndex < maxIndex) {
                            currentIndex++;
                            updateSlider();
                        }
                    }
                    if (touchEndX > touchStartX + 50) {
                        if (currentIndex > 0) {
                            currentIndex--;
                            updateSlider();
                        }
                    }
                }
                
                let resizeTimeout;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(updateConfig, 250);
                });
                
                // Delay init slightly to ensure widths are filled
                setTimeout(updateConfig, 100);
            });
            </script>
            <?php endif; ?>
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
    formData.append('nonce', torg_config.favorite_nonce);
    
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
    formData.append('nonce', torg_config.cart_nonce);
    
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
