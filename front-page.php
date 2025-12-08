<?php
/**
 * The template for displaying the front page
 *
 * @package torg-vent-brest
 */

get_header();
?>

<main id="primary" class="site-main">

<!-- Hero Section -->
<section class="relative py-12 lg:py-20 min-h-[500px] lg:min-h-[574px] overflow-hidden bg-[url('/wp-content/themes/torg-vent-brest/assets/images/Фон.png')] bg-cover bg-center">
	<div class="container mx-auto px-4 max-w-[1240px] relative z-10 flex flex-col lg:flex-row items-center h-full">
		<div class="w-full lg:w-3/5 mb-10 lg:mb-0 pt-10 lg:pt-0">
			<h1 class="text-[26px] md:text-[36px] font-bold text-gray-800 leading-tight mb-6">
				Профессиональный монтаж <br>
				и продажа холодильного <br>
				и климатического оборудования
			</h1>
			<ul class="space-y-3 mb-8">
				<li class="flex items-center text-gray-700 text-sm md:text-base">
					<i class="fa-solid fa-check text-primary mr-3"></i>
					Бесплатный выезд на замер
				</li>
				<li class="flex items-center text-gray-700 text-sm md:text-base">
					<i class="fa-solid fa-check text-primary mr-3"></i>
					Только сертифицированное оборудование
				</li>
				<li class="flex items-center text-gray-700 text-sm md:text-base">
					<i class="fa-solid fa-check text-primary mr-3"></i>
					Монтаж за 1 день
				</li>
			</ul>
			<?php
			// Get catalog page URL or fallback
            // Assuming '/catalog' or searching for a page
			$catalog_page = get_pages(array(
				'meta_key' => '_wp_page_template',
				'meta_value' => 'page-catalog.php'
			));
			$catalog_url = !empty($catalog_page) ? get_permalink($catalog_page[0]->ID) : '#';
			?>
			<a href="<?php echo esc_url($catalog_url); ?>" class="inline-block main-button uppercase text-white font-bold py-3 px-8 rounded transition shadow-lg shadow-blue-500/30 text-sm md:text-base">
				Перейти в каталог
			</a>
		</div>
	</div>
</section>

    <!-- Categories Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-[1240px]">
            <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-12">Каталог продукции</h2>
            
            <?php
            // Get all product categories
            $product_categories = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
            ));
            
            if (!empty($product_categories) && !is_wp_error($product_categories)) :
                $total_categories = count($product_categories);
                ?>
                
                <div class="relative px-0 lg:px-0">
                    <!-- Categories Slider Container -->
                    <div class="overflow-hidden">
                        <div id="categories-slider" class="flex gap-6 transition-transform duration-500 ease-in-out">
                            <?php
                            foreach ($product_categories as $index => $category) :
                                $category_link = get_term_link($category);
                                $category_image = get_field('category_image', 'product_cat_' . $category->term_id);
                                ?>
                                <!-- Category Item -->
                                <!-- Adaptive widths: Mobile 100%, Tablet 50% (minus gap), Desktop 25% (minus gap) -->
                                <a href="<?php echo esc_url($category_link); ?>" class="category-item group bg-white rounded-lg p-6 shadow-sm hover:shadow-md border border-gray-100 transition text-center relative block no-underline flex-shrink-0 w-full sm:w-[calc(50%-12px)] lg:w-[calc(25%-18px)]">
                                    <div class="h-40 flex items-center justify-center mb-4">
                                        <?php if ($category_image) : ?>
                                            <img src="<?php echo esc_url($category_image['url']); ?>" alt="<?php echo esc_attr($category->name); ?>" class="max-h-full max-w-full object-contain group-hover:scale-110 transition">
                                        <?php else : ?>
                                            <img src="https://placehold.co/150x150/f3f4f6/9ca3af?text=<?php echo urlencode(substr($category->name, 0, 10)); ?>" alt="<?php echo esc_attr($category->name); ?>" class="max-h-full group-hover:scale-110 transition">
                                        <?php endif; ?>
                                    </div>
                                    <h3 class="text-sm font-semibold text-gray-700 group-hover:text-primary transition"><?php echo esc_html($category->name); ?></h3>
                                </a>
                                <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                    
                    <!-- Navigation Arrows -->
                    <?php if ($total_categories > 1) : ?>
                    <!-- Previous Arrow -->
                    <button id="categories-prev" class="absolute top-1/2 left-0 lg:-left-4 transform -translate-y-1/2 bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition z-10 opacity-50 cursor-not-allowed hidden sm:flex" disabled>
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    
                    <!-- Next Arrow -->
                    <button id="categories-next" class="absolute top-1/2 right-0 lg:-right-4 transform -translate-y-1/2 bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition z-10 hidden sm:flex">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                    
                    <!-- Slider Script -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const slider = document.getElementById('categories-slider');
                            const prevBtn = document.getElementById('categories-prev');
                            const nextBtn = document.getElementById('categories-next');
                            const items = document.querySelectorAll('.category-item');
                            const totalItems = items.length;
                            let currentIndex = 0;
                            let visibleItems = 4;
                            let maxIndex = 0;

                            function updateConfig() {
                                const w = window.innerWidth;
                                if (w >= 1024) visibleItems = 4; // LG
                                else if (w >= 640) visibleItems = 2; // SM
                                else visibleItems = 1; // Mobile

                                maxIndex = Math.max(0, totalItems - visibleItems);
                                
                                // Reset if out of bounds
                                if (currentIndex > maxIndex) currentIndex = maxIndex;
                                updateSlider();
                            }
                            
                            function updateSlider() {
                                // Calculate offset
                                const itemWidth = items[0].offsetWidth;
                                const gap = 24; 
                                const offset = currentIndex * (itemWidth + gap);
                                
                                slider.style.transform = `translateX(-${offset}px)`;
                                
                                // Update buttons (if exists)
                                if(prevBtn) {
                                    if (currentIndex === 0) {
                                        prevBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                        prevBtn.disabled = true;
                                    } else {
                                        prevBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                                        prevBtn.disabled = false;
                                    }
                                }
                                
                                if(nextBtn) {
                                    if (currentIndex >= maxIndex) {
                                        nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                        nextBtn.disabled = true;
                                    } else {
                                        nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                                        nextBtn.disabled = false;
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

                            // Touch / Swipe support for mobile
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
                                    // Swipe Left (Next)
                                    if (currentIndex < maxIndex) {
                                        currentIndex++;
                                        updateSlider();
                                    }
                                }
                                if (touchEndX > touchStartX + 50) {
                                    // Swipe Right (Prev)
                                    if (currentIndex > 0) {
                                        currentIndex--;
                                        updateSlider();
                                    }
                                }
                            }
                            
                            // Resize
                            let resizeTimeout;
                            window.addEventListener('resize', function() {
                                clearTimeout(resizeTimeout);
                                resizeTimeout = setTimeout(function() {
                                    updateConfig();
                                }, 250);
                            });
                            
                            // Init
                            updateConfig();
                        });
                    </script>
                    <?php endif; ?>
                </div>
                
            <?php else : ?>
                <div class="text-center text-gray-500 py-8">
                    <p>Категории товаров не найдены.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- New Products Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-[1240px]">
            <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-12">Новинки</h2>
            
            <?php
            $new_products = new WP_Query(array(
                'post_type' => 'product',
                'posts_per_page' => 8,
                'meta_key' => 'is_new',
                'meta_value' => '1',
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            if ($new_products->have_posts()) :
            ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php while ($new_products->have_posts()) : $new_products->the_post(); 
                    $price = get_field('product_price');
                    $old_price = get_field('product_old_price');
                    $is_sale = get_field('is_on_sale');
                    $code = get_field('product_code');
                    
                    // Image logic: Featured > Custom Field > Placeholder
                    $image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                    if(!$image) {
                         $custom_img = get_field('product_custom_image');
                         $image = $custom_img ? $custom_img['url'] : 'https://placehold.co/200x200/f3f4f6/9ca3af?text=Нет+фото';
                    }
                ?>
                <!-- Product Card -->
                <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition flex flex-col relative h-full group">
                    <?php if($is_sale): ?>
                        <span class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded z-10">АКЦИЯ</span>
                    <?php endif; ?>
                    
                    <button class="absolute top-4 right-4 text-gray-300 hover:text-red-500 transition z-10"><i class="fa-regular fa-heart"></i></button>
                    
                    <a href="<?php the_permalink(); ?>" class="block h-40 flex items-center justify-center mb-4 p-4 overflow-hidden">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>" class="max-h-full object-contain group-hover:scale-105 transition duration-300">
                    </a>
                    
                    <a href="<?php the_permalink(); ?>" class="block flex-grow">
                        <h3 class="text-sm font-medium text-gray-800 mb-2 line-clamp-2 min-h-[40px] hover:text-[#1E65C6] transition"><?php the_title(); ?></h3>
                    </a>
                    
                    <?php if($code): ?>
                    <div class="text-xs text-gray-500 mb-4">Код товара: <?php echo esc_html($code); ?></div>
                    <?php else: ?>
                    <div class="text-xs text-transparent mb-4 select-none">Код товара: 00000</div>
                    <?php endif; ?>
                    
                    <div class="mt-auto">
                        <div class="text-lg font-bold text-red-500 mb-3">
                            <?php 
                            if($price) echo number_format($price, 2, '.', ' ') . ' руб.'; 
                            else echo 'Цена по запросу';
                            ?>
                        </div>
                        <button class="w-full bg-[#1E65C6] hover:bg-[#154b96] text-white font-bold py-2.5 rounded transition text-sm uppercase tracking-wide shadow-blue-500/20 shadow-md hover:shadow-lg">
                            В КОРЗИНУ
                        </button>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <?php else: ?>
                <div class="bg-white rounded-lg p-10 text-center shadow-sm">
                    <p class="text-gray-500 text-lg mb-4">Новинки пока не добавлены.</p>
                    <?php if(current_user_can('edit_posts')): ?>
                    <p class="text-sm text-gray-400">Перейдите в "Товары", выберите товар и отметьте галочку "Товар новинка".</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Popular Products Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-[1240px]">
            <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-12">Популярные товары</h2>
            
            <?php
            $popular_products = new WP_Query(array(
                'post_type' => 'product',
                'posts_per_page' => 8,
                'meta_key' => 'is_popular',
                'meta_value' => '1',
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            if ($popular_products->have_posts()) :
            ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php while ($popular_products->have_posts()) : $popular_products->the_post(); 
                    $price = get_field('product_price');
                    $old_price = get_field('product_old_price');
                    $is_sale = get_field('is_on_sale');
                    $code = get_field('product_code');
                    
                    // Image logic: Featured > Custom Field > Placeholder
                    $image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                    if(!$image) {
                         $custom_img = get_field('product_custom_image');
                         $image = $custom_img ? $custom_img['url'] : 'https://placehold.co/200x200/f3f4f6/9ca3af?text=Нет+фото';
                    }
                ?>
                <!-- Product Card -->
                <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition flex flex-col relative h-full group border border-gray-100">
                    <?php if($is_sale): ?>
                        <span class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded z-10">АКЦИЯ</span>
                    <?php endif; ?>
                    
                    <button class="absolute top-4 right-4 text-gray-300 hover:text-red-500 transition z-10"><i class="fa-regular fa-heart"></i></button>
                    
                    <a href="<?php the_permalink(); ?>" class="block h-40 flex items-center justify-center mb-4 p-4 overflow-hidden">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>" class="max-h-full object-contain group-hover:scale-105 transition duration-300">
                    </a>
                    
                    <a href="<?php the_permalink(); ?>" class="block flex-grow">
                        <h3 class="text-sm font-medium text-gray-800 mb-2 line-clamp-2 min-h-[40px] hover:text-[#1E65C6] transition"><?php the_title(); ?></h3>
                    </a>
                    
                    <?php if($code): ?>
                    <div class="text-xs text-gray-500 mb-4">Код товара: <?php echo esc_html($code); ?></div>
                    <?php else: ?>
                    <div class="text-xs text-transparent mb-4 select-none">Код товара: 00000</div>
                    <?php endif; ?>
                    
                    <div class="mt-auto">
                        <div class="text-lg font-bold text-red-500 mb-3">
                            <?php 
                            if($price) echo number_format($price, 2, '.', ' ') . ' руб.'; 
                            else echo 'Цена по запросу';
                            ?>
                        </div>
                        <button class="w-full bg-[#1E65C6] hover:bg-[#154b96] text-white font-bold py-2.5 rounded transition text-sm uppercase tracking-wide shadow-blue-500/20 shadow-md hover:shadow-lg">
                            В КОРЗИНУ
                        </button>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <?php else: ?>
                <div class="bg-gray-50 rounded-lg p-10 text-center border border-gray-100">
                    <p class="text-gray-500 text-lg mb-4">Популярные товары пока не добавлены.</p>
                    <?php if(current_user_can('edit_posts')): ?>
                    <p class="text-sm text-gray-400">Перейдите в "Товары", выберите товар и отметьте галочку "Популярный товар".</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Brands Section -->
    <section class="py-12 bg-gray-50 border-t border-gray-200">
        <div class="container mx-auto px-4 max-w-[1240px]">
            <h2 class="text-xl font-bold text-center text-gray-800 mb-8">Бренды, с которыми мы работаем</h2>
            <div class="flex flex-wrap justify-center items-center gap-8 lg:gap-12 opacity-70 grayscale hover:grayscale-0 transition-all duration-500">
                <img src="https://placehold.co/100x40/e5e7eb/6b7280?text=LG" alt="LG" class="h-8 lg:h-10 object-contain">
                <img src="https://placehold.co/100x40/e5e7eb/6b7280?text=MDV" alt="MDV" class="h-8 lg:h-10 object-contain">
                <img src="https://placehold.co/120x40/e5e7eb/6b7280?text=Electrolux" alt="Electrolux" class="h-8 lg:h-10 object-contain">
                <img src="https://placehold.co/100x40/e5e7eb/6b7280?text=Cooper" alt="Cooper&Hunter" class="h-8 lg:h-10 object-contain">
                <img src="https://placehold.co/100x40/e5e7eb/6b7280?text=Ballu" alt="Ballu" class="h-8 lg:h-10 object-contain">
                <img src="https://placehold.co/80x40/e5e7eb/6b7280?text=TCL" alt="TCL" class="h-8 lg:h-10 object-contain">
            </div>
        </div>
    </section>

    <!-- Installation Promo -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-[1240px]">
            <div class="bg-blue-50 rounded-2xl overflow-hidden flex flex-col lg:flex-row items-center relative">
                <div class="p-8 lg:p-12 w-full lg:w-1/2 z-10">
                    <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-6">
                        Закажите монтаж систем <br>
                        кондиционирования и <br>
                        вентиляции у нас
                    </h2>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-gray-700 text-sm">
                            <i class="fa-solid fa-check text-primary mr-3"></i>
                            Только проверенные специалисты
                        </li>
                        <li class="flex items-center text-gray-700 text-sm">
                            <i class="fa-solid fa-check text-primary mr-3"></i>
                            Гарантия на все виды работ
                        </li>
                        <li class="flex items-center text-gray-700 text-sm">
                            <i class="fa-solid fa-check text-primary mr-3"></i>
                            Чистота после монтажа
                        </li>
                    </ul>
                    <a href="<?php echo home_url('/installation'); ?>" class="inline-block bg-primary hover:bg-blue-700 text-white font-bold py-3 px-8 rounded transition shadow-lg shadow-blue-500/30 text-sm">
                        ПОДРОБНЕЕ О МОНТАЖЕ
                    </a>
                </div>
                <div class="w-full lg:w-1/2 h-64 lg:h-auto relative">
                     <!-- Placeholder for Worker Image -->
                    <img src="https://placehold.co/600x400/dbeafe/1d63cc?text=Worker+Image" alt="Worker" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-[#F9FAFB]">
        <div class="container mx-auto px-4 max-w-[800px]">
             <?php
            // ACF Fields
            $faq_title = function_exists('get_field') ? get_field('home_faq_title') : '';
            if(!$faq_title) $faq_title = 'Часто задаваемые вопросы';
            
            $faq_list = function_exists('get_field') ? get_field('home_faq_list') : [];
            
            // Fallback if empty
            if (empty($faq_list)) {
                $faq_list = array(
                    array('question' => 'Вы производитель или посредник?', 'answer' => 'Компания является официальным дистрибьютором и партнером нескольких крупных производственных холдингов. Это позволяет нам предлагать клиентам цены от производителя, обеспечивая при этом широкий ассортимент и гибкость поставок. Мы работаем без посредников.'),
                    array('question' => 'С кем вы сотрудничаете?', 'answer' => 'Мы сотрудничаем с ведущими строительными компаниями, дизайнерами интерьеров и частными заказчиками по всей стране.'),
                    array('question' => 'Какой минимальный объем заказа?', 'answer' => 'Минимальный объем заказа зависит от типа продукции, но мы стараемся быть гибкими. Для большинства позиций ограничений нет.'),
                    array('question' => 'Как сделать заказ?', 'answer' => 'Вы можете оформить заказ через корзину на сайте, позвонить нам по телефону или написать в мессенджеры.'),
                    array('question' => 'Как я могу быть уверен в качестве продукции?', 'answer' => 'Вся наша продукция сертифицирована и имеет официальную гарантию производителя. Мы также проводим собственный контроль качества перед отправкой.'),
                    array('question' => 'Можно ли заказать продукцию с нашим логотипом?', 'answer' => 'Да, для корпоративных клиентов мы предоставляем услуги брендирования оборудования.'),
                    array('question' => 'Почему у вас цены ниже, чем у конкурентов?', 'answer' => 'Благодаря прямым поставкам от производителей и оптимизированной логистике мы можем держать цены на минимальном уровне.'),
                );
            }
            ?>
            
            <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-10"><?php echo esc_html($faq_title); ?></h2>
            
            <div class="space-y-4" id="faq-accordion">
                <?php foreach($faq_list as $index => $item): 
                    $q = is_array($item) ? $item['question'] : '';
                    $a = is_array($item) ? $item['answer'] : '';
                    if(!$q) continue;
                     // Open first item by default logic if needed? Reference shows first open. Let's keep all closed or open first?
                     // User asked: "открывался на клике". Usually starts closed.
                     // But reference image has 1st one open. I'll stick to all closed for cleaner initial load, or open 1st via JS.
                ?>
                <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group">
                    <button class="faq-toggle w-full flex justify-between items-start p-6 text-left focus:outline-none bg-white z-10 relative gap-4">
                        <span class="font-bold text-[#2D2D2D] text-[16px] md:text-[17px] pt-2 leading-tight"><?php echo esc_html($q); ?></span>
                        
                        <!-- Icon Button -->
                        <div class="icon-wrapper w-[42px] h-[42px] rounded-full bg-[#1E65C6] flex-shrink-0 flex items-center justify-center text-white transition-all duration-300 border border-transparent">
                            <i class="fa-solid fa-arrow-down transition-transform duration-300 text-[16px]"></i>
                        </div>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                        <div class="p-6 pt-0 text-gray-600 text-[14px] md:text-[15px] leading-relaxed">
                            <?php echo wp_kses_post(nl2br($a)); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <script>
            document.addEventListener('DOMContentLoaded', () => {
                const items = document.querySelectorAll('.faq-item');
                
                items.forEach((item, index) => {
                    const toggle = item.querySelector('.faq-toggle');
                    const content = item.querySelector('.faq-content');
                    const icon = item.querySelector('.fa-arrow-down');
                    const iconWrapper = item.querySelector('.icon-wrapper');
                    
                    // Function to set state
                    const setOpen = (open) => {
                        if (open) {
                            item.classList.add('active');
                            content.style.maxHeight = content.scrollHeight + 'px';
                            if(icon) icon.style.transform = 'rotate(180deg)';
                            
                            // Style: White bg, gray border, gray arrow
                            if(iconWrapper) {
                                iconWrapper.classList.remove('bg-[#1E65C6]', 'text-white', 'border-transparent');
                                iconWrapper.classList.add('bg-white', 'text-gray-400', 'border-gray-200');
                            }
                        } else {
                            item.classList.remove('active');
                            content.style.maxHeight = '0';
                            if(icon) icon.style.transform = 'rotate(0deg)';
                            
                            // Style: Blue bg, white arrow, transparent border
                            if(iconWrapper) {
                                iconWrapper.classList.add('bg-[#1E65C6]', 'text-white', 'border-transparent');
                                iconWrapper.classList.remove('bg-white', 'text-gray-400', 'border-gray-200');
                            }
                        }
                    };

                    toggle.addEventListener('click', () => {
                        const isOpen = item.classList.contains('active');
                        
                        // Close all others
                        items.forEach(otherItem => {
                            if(otherItem !== item && otherItem.classList.contains('active')) {
                                // Manual close mainly to avoid recursion issues if I used a method, but direct DOM maniupalation is mostly fine here
                                otherItem.classList.remove('active');
                                otherItem.querySelector('.faq-content').style.maxHeight = '0';
                                
                                const otherIcon = otherItem.querySelector('.fa-arrow-down');
                                if(otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                                
                                const otherWrapper = otherItem.querySelector('.icon-wrapper');
                                if(otherWrapper) {
                                    otherWrapper.classList.add('bg-[#1E65C6]', 'text-white', 'border-transparent');
                                    otherWrapper.classList.remove('bg-white', 'text-gray-400', 'border-gray-200');
                                }
                            }
                        });
                        
                        setOpen(!isOpen);
                    });
                    
                    // Open first item by default to match reference look?
                    if (index === 0) {
                        setOpen(true);
                    }
                });
            });
            </script>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-[1240px]">
            <?php
            // Get image from Installation Page for consistency
            $install_pages = get_pages(array(
                'meta_key' => '_wp_page_template',
                'meta_value' => 'page-installation.php',
                'number' => 1
            ));
            $contact_image = (!empty($install_pages)) ? get_field('contact_image', $install_pages[0]->ID) : '';
            
            get_template_part('template-parts/section', 'consultation-form', array(
                'title' => 'Остались вопросы?',
                'desc' => 'Оставьте ваши контактные данные. Проконсультируем по всем интересующим вопросам и поможем подобрать климатическую технику',
                'image' => $contact_image,
                'btn_text' => 'ОТПРАВИТЬ',
                'footer_text' => 'Позвоните нам или напишите',
                'form_id' => 'home-page-form',
                'message_id' => 'form-message-home',
            )); 
            ?>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer();
