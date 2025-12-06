<?php
/**
 * The template for displaying single product
 *
 * @package torg-vent-brest
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <?php
    while (have_posts()) :
        the_post();
        
        // Get ACF fields
        $product_code = get_field('product_code');
        $product_old_price = get_field('product_old_price');
        $product_price = get_field('product_price');
        $product_brand = get_field('product_brand');
        $product_model = get_field('product_model');
        $product_brand_country = get_field('product_brand_country');
        $product_manufacture_country = get_field('product_manufacture_country');
        $product_measure_unit = get_field('product_measure_unit');
        $product_additional_specs = get_field('product_additional_specs');

        $is_on_sale = get_field('is_on_sale');
        $is_new = get_field('is_new');
        
        // Modified fields for Free ACF compatibility
        $product_specs_editor = get_field('product_specs_editor');
        $product_instructions_editor = get_field('product_instructions_editor');
        
        // Build gallery from individual image fields
        $product_gallery = array();
        for ($i = 1; $i <= 5; $i++) {
            $img = get_field('product_image_' . $i);
            if ($img) {
                $product_gallery[] = $img;
            }
        }
        ?>
        
        <!-- Breadcrumbs -->
        <section class="bg-gray-50 py-4">
            <div class="container mx-auto px-4 max-w-[1200px]">
                <nav class="text-[14px] text-gray-600">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary transition">Главная</a>
                    <span class="mx-2">/</span>
                    <?php
                    $categories = get_the_terms(get_the_ID(), 'product_cat');
                    if ($categories && !is_wp_error($categories)) :
                        $category = $categories[0];
                        ?>
                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="hover:text-primary transition"><?php echo esc_html($category->name); ?></a>
                        <span class="mx-2">/</span>
                        <?php
                    endif;
                    ?>
                    <span class="text-[#057EE5]"><?php the_title(); ?></span>
                </nav>
            </div>
        </section>

        <!-- Product Content -->
        <section class="py-12 bg-[#F7F9FB]">
            <div class="container mx-auto px-4 max-w-[1200px]">
                
                <!-- Product Title with Sale Badge -->
                <div class="mb-8 relative">
                    <h1 class="text-3xl md:text-4xl md:text-center font-bold text-gray-800"><?php the_title(); ?></h1>
                </div>

                <!-- Product Main Info -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                    
                    <!-- Product Image Gallery -->
                    <div class="flex flex-col items-center">
                        <div class="mb-4 bg-white sm:mt-4 sm:w-[486px] sm:h-[486px] rounded-lg p-8 flex items-center justify-center relative group">
                            <?php if ($is_new) : ?>
                                <span class="absolute top-4 left-4 bg-[#E3000F] text-white text-xs font-bold px-3 py-1 rounded z-20">Новинка</span>
                            <?php endif; ?>
                            
                            <?php 
                            $main_image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                            if ($main_image_url) : ?>
                                <img id="main-product-image" src="<?php echo esc_url($main_image_url); ?>" alt="<?php the_title_attribute(); ?>" class="max-w-full h-auto object-contain max-h-[500px] transition-opacity duration-300">
                            <?php else: ?>
                                <img id="main-product-image" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder.png'); ?>" alt="Placeholder" class="max-w-full h-auto object-contain max-h-[500px]">
                            <?php endif; ?>
                        </div>
                        
                        <!-- Additional Images Carousel -->
                        <?php 
                        // Combine main image and gallery images
                        $all_images = array();
                        
                        if ($main_image_url) {
                            $all_images[] = array(
                                'url' => $main_image_url,
                                'thumb' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                                'alt' => get_the_title()
                            );
                        }

                        if ($product_gallery) {
                            foreach ($product_gallery as $image) {
                                $all_images[] = array(
                                    'url' => $image['sizes']['large'],
                                    'thumb' => $image['sizes']['thumbnail'],
                                    'alt' => $image['alt']
                                );
                            }
                        }
                        
                        if (count($all_images) > 1) : ?>
                            <div class="relative px-8 w-fit mx-auto">
                                <!-- Navigation Buttons -->
                                <button id="prev-slide" class="absolute left-0 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-white border border-gray-200 rounded-full shadow hover:bg-gray-50 text-gray-600 z-10">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                                <button id="next-slide" class="absolute right-0 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-white border border-gray-200 rounded-full shadow hover:bg-gray-50 text-gray-600 z-10">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>

                                <!-- Thumbnails Container -->
                                <div id="thumbnails-container" class="overflow-hidden py-2 max-w-[432px]">
                                    <div class="flex gap-2 transition-transform duration-300" id="thumbnails-track">
                                        <?php foreach ($all_images as $index => $img) : ?>
                                            <div class="flex-shrink-0 w-20 h-20 border-2 <?php echo $index === 0 ? 'border-primary' : 'border-transparent'; ?> rounded cursor-pointer hover:border-primary transition p-1 bg-white thumbnail-item" 
                                                 onclick="changeMainImage('<?php echo esc_url($img['url']); ?>', this)">
                                                <img src="<?php echo esc_url($img['thumb']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-full h-full object-contain">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <style>
                                .hide-scrollbar::-webkit-scrollbar {
                                    display: none;
                                }
                                .hide-scrollbar {
                                    -ms-overflow-style: none;
                                    scrollbar-width: none;
                                }
                            </style>

                            <script>
                                function changeMainImage(url, element) {
                                    const mainImage = document.getElementById('main-product-image');
                                    
                                    // Fade out
                                    mainImage.style.opacity = '0.5';
                                    
                                    setTimeout(() => {
                                        mainImage.src = url;
                                        // Fade in
                                        mainImage.style.opacity = '1';
                                    }, 150);

                                    // Update active border
                                    document.querySelectorAll('.thumbnail-item').forEach(el => {
                                        el.classList.remove('border-primary');
                                        el.classList.add('border-transparent');
                                    });
                                    element.classList.remove('border-transparent');
                                    element.classList.add('border-primary');
                                }

                                // Carousel Navigation
                                const track = document.getElementById('thumbnails-track');
                                const prevBtn = document.getElementById('prev-slide');
                                const nextBtn = document.getElementById('next-slide');
                                
                                let currentPosition = 0;
                                const thumbnailWidth = 88; // 80px width + 8px gap
                                const visibleCount = 5;
                                const totalThumbnails = track.children.length;
                                const maxPosition = Math.max(0, totalThumbnails - visibleCount);

                                prevBtn.addEventListener('click', () => {
                                    if (currentPosition > 0) {
                                        currentPosition--;
                                        track.style.transform = `translateX(-${currentPosition * thumbnailWidth}px)`;
                                    }
                                });

                                nextBtn.addEventListener('click', () => {
                                    if (currentPosition < maxPosition) {
                                        currentPosition++;
                                        track.style.transform = `translateX(-${currentPosition * thumbnailWidth}px)`;
                                    }
                                });
                            </script>
                        <?php endif; ?>
                    </div>

                    <!-- Product Info -->
                    <div>
                        <div class="bg-gray-50 rounded-lg p-4 mb-2">
                            <?php if ($product_code) : ?>
                                <div class="text-gray-500 mb-4">Код товара: <?php echo esc_html($product_code); ?></div>
                            <?php endif; ?>
                            <h2 class="text-xl font-bold mb-4">ХАРАКТЕРИСТИКИ:</h2>
                            <div class="text-[16px]">
                                <?php if ($product_brand) : ?>
                                    <div class="flex justify-between border-b border-gray-200 pb-2">
                                        <span class="font-medium">Производитель:</span>
                                        <span><?php echo esc_html($product_brand); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($product_model) : ?>
                                    <div class="flex justify-between border-b border-gray-200 pb-2">
                                        <span class="font-medium">Модель:</span>
                                        <span><?php echo esc_html($product_model); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($product_code) : ?>
                                    <div class="flex justify-between border-b border-gray-200 pb-2">
                                        <span class="font-medium">Артикул производителя:</span>
                                        <span><?php echo esc_html($product_code); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($product_brand_country) : ?>
                                    <div class="flex justify-between border-b border-gray-200 pb-2">
                                        <span class="font-medium">Страна бренда:</span>
                                        <span><?php echo esc_html($product_brand_country); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($product_manufacture_country) : ?>
                                    <div class="flex justify-between border-b border-gray-200 pb-2">
                                        <span class="font-medium">Страна производства:</span>
                                        <span><?php echo esc_html($product_manufacture_country); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($product_measure_unit) : ?>
                                    <div class="flex justify-between border-b border-gray-200 pb-2">
                                        <span class="font-medium">Ед. измерения:</span>
                                        <span><?php echo esc_html($product_measure_unit); ?></span>
                                    </div>
                                <?php endif; ?>

                                <!-- Additional Specs (Hidden by default) -->
                                <?php if ($product_additional_specs) : 
                                    $specs_lines = explode("\n", $product_additional_specs);
                                    ?>
                                    <div id="additional-specs" class="hidden space-y-2">
                                        <?php foreach ($specs_lines as $line) : 
                                            $parts = explode(':', $line, 2);
                                            if (count($parts) === 2) :
                                                $name = trim($parts[0]);
                                                $value = trim($parts[1]);
                                                ?>
                                                <div class="flex justify-between border-b border-gray-200 pb-1">
                                                    <span class="font-medium"><?php echo esc_html($name); ?>:</span>
                                                    <span><?php echo esc_html($value); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <button id="toggle-specs-btn" class="text-primary hover:text-blue-700 text-[16px] font-medium focus:outline-none border-b border-dashed border-primary hover:border-blue-700 transition inline-block">
                                        Все характеристики
                                    </button>

                                    <script>
                                        document.getElementById('toggle-specs-btn').addEventListener('click', function() {
                                            const specsDiv = document.getElementById('additional-specs');
                                            const isHidden = specsDiv.classList.contains('hidden');
                                            
                                            if (isHidden) {
                                                specsDiv.classList.remove('hidden');
                                                this.textContent = 'Скрыть характеристики';
                                            } else {
                                                specsDiv.classList.add('hidden');
                                                this.textContent = 'Все характеристики';
                                            }
                                        });
                                    </script>
                                <?php endif; ?>


                            </div>
                        </div>

                        <!-- Price and Order -->
                        <?php if ($product_price) : ?>
                            <div class="mb-6">
                                
                                <div class="flex items-center sm:ml-[20px]">
																	<div class="text-[26px] font-bold text-[#EE0025] mb-4 mr-2">
																		<?php echo esc_html(number_format($product_price, 2, '.', ' ')); ?> руб.
																	</div>
																	<?php if ($is_on_sale && $product_old_price) : ?>
																		<div class="text-[16px] text-gray-400 line-through pb-1">
																			<?php echo esc_html(number_format($product_old_price, 2, '.', ' ')); ?> руб.
																		</div>
																	<?php endif; ?>
																</div>
                                
                                <!-- Quantity and Add to Cart -->
                                <div class="flex items-center gap-4 mb-4 sm:ml-[20px] p-[16px] bg-white rounded-2 sm:mt-2 shadow-lg">
                                    <div class="flex sm:h-[50px] items-center border border-gray-300 rounded">
                                        <button class="px-4 py-2 hover:bg-gray-100 transition">-</button>
                                        <input type="number" value="1" min="1" class="pl-3 w-16 text-center border-x border-gray-300 py-2">
                                        <button class="px-4 py-2 hover:bg-gray-100 transition">+</button>
                                    </div>
                                    <button class="main-button shadow-lg border-1 flex-1 sm:h-[50px] text-white font-bold py-3 px-8 rounded">
                                        В КОРЗИНУ
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Product Description -->
                <?php if (get_the_content()) : ?>
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold mb-4">ОПИСАНИЕ ТОВАРА</h2>
                        <div class="prose max-w-none">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Technical Specifications (WYSIWYG) -->
                <?php if ($product_specs_editor) : ?>
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold mb-4">ХАРАКТЕРИСТИКИ ТОВАРА</h2>
                        <div class="prose max-w-none bg-white border border-gray-200 rounded-lg p-6">
                            <?php echo $product_specs_editor; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Instructions (WYSIWYG) -->
                <?php if ($product_instructions_editor) : ?>
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold mb-4">ИНСТРУКЦИИ</h2>
                        <div class="prose max-w-none">
                            <?php echo $product_instructions_editor; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Recommended Products -->
                <div class="mb-12">
                    <h2 class="text-2xl font-bold mb-6">Рекомендуемые товары</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php
                        // Get related products from same category
                        $current_categories = get_the_terms(get_the_ID(), 'product_cat');
                        if ($current_categories && !is_wp_error($current_categories)) :
                            $category_ids = array();
                            foreach ($current_categories as $cat) {
                                $category_ids[] = $cat->term_id;
                            }
                            
                            $related_products = new WP_Query(array(
                                'post_type' => 'product',
                                'posts_per_page' => 4,
                                'post__not_in' => array(get_the_ID()),
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'term_id',
                                        'terms' => $category_ids,
                                    ),
                                ),
                            ));
                            
                            if ($related_products->have_posts()) :
                                while ($related_products->have_posts()) : $related_products->the_post();
                                    $rel_price = get_field('product_price');
                                    $rel_code = get_field('product_code');
                                    $rel_on_sale = get_field('is_on_sale');
                                    ?>
                                    <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md border border-gray-100 transition flex flex-col relative group">
                                        <?php if ($rel_on_sale) : ?>
                                            <span class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded z-10">АКЦИЯ</span>
                                        <?php endif; ?>
                                        
                                        <a href="<?php the_permalink(); ?>" class="block">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="h-40 flex items-center justify-center mb-4 p-4">
                                                    <?php the_post_thumbnail('medium', array('class' => 'max-h-full max-w-full object-contain group-hover:scale-105 transition')); ?>
                                                </div>
                                            <?php endif; ?>
                                            <h3 class="text-sm font-medium text-gray-800 mb-2 line-clamp-2 min-h-[40px]"><?php the_title(); ?></h3>
                                        </a>
                                        
                                        <?php if ($rel_code) : ?>
                                            <div class="text-xs text-gray-500 mb-4">Код: <?php echo esc_html($rel_code); ?></div>
                                        <?php endif; ?>
                                        
                                        <div class="mt-auto">
                                            <?php if ($rel_price) : ?>
                                                <div class="text-lg font-bold text-red-500 mb-3"><?php echo esc_html(number_format($rel_price, 2, '.', ' ')); ?> руб.</div>
                                            <?php endif; ?>
                                            <button class="w-full bg-primary hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition text-sm">
                                                В КОРЗИНУ
                                            </button>
                                        </div>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                        endif;
                        ?>
                    </div>
                </div>

            </div>
        </section>

    <?php
    endwhile;
    ?>

</main><!-- #main -->

<?php
get_footer();
