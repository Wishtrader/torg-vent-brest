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
<section class="relative py-12 lg:py-20 sm:min-h-[574px] overflow-hidden bg-[url('/wp-content/themes/torg-vent-brest/assets/images/Фон.png')] bg-cover bg-center">
	<div class="container mx-auto px-4 max-w-[1200px] relative z-10 flex flex-col lg:flex-row items-center">
		<div class="w-full lg:w-3/5 mb-10 lg:mb-0">
			<h1 class="text-[22px] md:text-[36px] font-bold text-gray-800 leading-tight mb-6">
				Профессиональный монтаж <br>
				и продажа холодильного <br>
				и климатического оборудования
			</h1>
			<ul class="space-y-3 mb-8">
				<li class="flex items-center text-gray-700">
					<i class="fa-solid fa-check text-primary mr-3"></i>
					Бесплатный выезд на замер
				</li>
				<li class="flex items-center text-gray-700">
					<i class="fa-solid fa-check text-primary mr-3"></i>
					Только сертифицированное оборудование
				</li>
				<li class="flex items-center text-gray-700">
					<i class="fa-solid fa-check text-primary mr-3"></i>
					Монтаж за 1 день
				</li>
			</ul>
			<?php
			// Get catalog page URL
			$catalog_page = get_pages(array(
				'meta_key' => '_wp_page_template',
				'meta_value' => 'page-catalog.php'
			));
			$catalog_url = !empty($catalog_page) ? get_permalink($catalog_page[0]->ID) : '#';
			?>
			<a href="<?php echo esc_url($catalog_url); ?>" class="inline-block main-button uppercase text-white font-bold py-3 px-8 rounded transition shadow-lg shadow-blue-500/30">
				Перейти в каталог
			</a>
		</div>
	</div>
</section>

    <!-- Categories Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-[1200px]">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Каталог продукции</h2>
            
            <?php
            // Get all product categories
            $product_categories = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
            ));
            
            if (!empty($product_categories) && !is_wp_error($product_categories)) :
                $total_categories = count($product_categories);
                ?>
                
                <div class="relative px-8 lg:px-0">
                    <!-- Categories Slider Container -->
                    <div class="overflow-hidden">
                        <div id="categories-slider" class="flex gap-6 transition-transform duration-500 ease-in-out">
                            <?php
                            foreach ($product_categories as $index => $category) :
                                $category_link = get_term_link($category);
                                $category_image = get_field('category_image', 'product_cat_' . $category->term_id);
                                ?>
                                <!-- Category Item -->
                                <a href="<?php echo esc_url($category_link); ?>" class="category-item group bg-white rounded-lg p-6 shadow-sm hover:shadow-md border border-gray-100 transition text-center relative block no-underline flex-shrink-0" style="width: calc((100% - 72px) / 4);">
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
                    <?php if ($total_categories > 4) : ?>
                    <!-- Previous Arrow -->
                    <button id="categories-prev" class="absolute top-1/2 left-0 lg:-left-4 transform -translate-y-1/2 bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition z-10 opacity-50 cursor-not-allowed" disabled>
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    
                    <!-- Next Arrow -->
                    <button id="categories-next" class="absolute top-1/2 right-0 lg:-right-4 transform -translate-y-1/2 bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition z-10">
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
                            const maxIndex = totalItems - 4; // Maximum scroll position
                            
                            function updateSlider() {
                                // Calculate the width of one item including gap
                                const itemWidth = items[0].offsetWidth;
                                const gap = 24; // gap-6 = 1.5rem = 24px
                                const offset = currentIndex * (itemWidth + gap);
                                
                                // Apply transform
                                slider.style.transform = `translateX(-${offset}px)`;
                                
                                // Update button states
                                if (currentIndex === 0) {
                                    prevBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                    prevBtn.disabled = true;
                                } else {
                                    prevBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                                    prevBtn.disabled = false;
                                }
                                
                                if (currentIndex >= maxIndex) {
                                    nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                    nextBtn.disabled = true;
                                } else {
                                    nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                                    nextBtn.disabled = false;
                                }
                            }
                            
                            nextBtn.addEventListener('click', function() {
                                if (currentIndex < maxIndex) {
                                    currentIndex++;
                                    updateSlider();
                                }
                            });
                            
                            prevBtn.addEventListener('click', function() {
                                if (currentIndex > 0) {
                                    currentIndex--;
                                    updateSlider();
                                }
                            });
                            
                            // Update on window resize
                            let resizeTimeout;
                            window.addEventListener('resize', function() {
                                clearTimeout(resizeTimeout);
                                resizeTimeout = setTimeout(function() {
                                    currentIndex = 0;
                                    slider.style.transform = 'translateX(0)';
                                    updateSlider();
                                }, 250);
                            });
                            
                            // Initial update
                            updateSlider();
                        });
                    </script>
                    <?php endif; ?>
                </div>
                
            <?php else : ?>
                <!-- Fallback if no categories found -->
                <div class="text-center text-gray-500 py-8">
                    <p>Категории товаров не найдены. Добавьте категории в WordPress.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- New Products Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-[1200px]">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Новинки</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php for($i=0; $i<8; $i++): ?>
                <!-- Product Card -->
                <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition flex flex-col relative">
                    <span class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded">АКЦИЯ</span>
                    <button class="absolute top-4 right-4 text-gray-300 hover:text-red-500 transition"><i class="fa-regular fa-heart"></i></button>
                    
                    <div class="h-40 flex items-center justify-center mb-4 p-4">
                        <img src="https://placehold.co/200x100/f3f4f6/9ca3af?text=Product" alt="Product" class="max-h-full">
                    </div>
                    
                    <h3 class="text-sm font-medium text-gray-800 mb-2 line-clamp-2 h-10">Сплит-система Haier AS25S2SF1FA-W / 1U25S2SM1FA</h3>
                    <div class="text-xs text-gray-500 mb-4">Код товара: 12345</div>
                    
                    <div class="mt-auto">
                        <div class="text-lg font-bold text-red-500 mb-3">1 850.00 руб.</div>
                        <button class="w-full bg-primary hover:bg-blue-700 text-white font-medium py-2 rounded transition text-sm">
                            В КОРЗИНУ
                        </button>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- Popular Products Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-[1200px]">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Популярные товары</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">
                 <!-- Arrow Button -->
                 <button class="absolute top-1/2 -right-4 transform -translate-y-1/2 bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition z-10 hidden lg:flex">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

                <?php for($i=0; $i<4; $i++): ?>
                <!-- Product Card -->
                <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md border border-gray-100 transition flex flex-col relative">
                    <button class="absolute top-4 right-4 text-gray-300 hover:text-red-500 transition"><i class="fa-regular fa-heart"></i></button>
                    
                    <div class="h-40 flex items-center justify-center mb-4 p-4">
                        <img src="https://placehold.co/200x100/f3f4f6/9ca3af?text=Popular" alt="Product" class="max-h-full">
                    </div>
                    
                    <h3 class="text-sm font-medium text-gray-800 mb-2 line-clamp-2 h-10">Кондиционер Gree GWH09AAA-K3NNA2A</h3>
                    <div class="text-xs text-gray-500 mb-4">Код товара: 54321</div>
                    
                    <div class="mt-auto">
                        <div class="text-lg font-bold text-red-500 mb-3">1 200.00 руб.</div>
                        <button class="w-full bg-primary hover:bg-blue-700 text-white font-medium py-2 rounded transition text-sm">
                            В КОРЗИНУ
                        </button>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- Brands Section -->
    <section class="py-12 bg-gray-50 border-t border-gray-200">
        <div class="container mx-auto px-4 max-w-[1200px]">
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
        <div class="container mx-auto px-4 max-w-[1200px]">
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
                    <a href="#" class="inline-block bg-primary hover:bg-blue-700 text-white font-bold py-3 px-8 rounded transition shadow-lg shadow-blue-500/30 text-sm">
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
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-[800px]">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-10">Часто задаваемые вопросы</h2>
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 transition text-left">
                        <span class="font-medium text-gray-700 text-sm">Как происходит оплата за услуги?</span>
                        <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                    </button>
                </div>
                <!-- FAQ Item 2 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 transition text-left">
                        <span class="font-medium text-gray-700 text-sm">Сроки выполнения работ?</span>
                        <i class="fa-solid fa-chevron-down text-primary text-xs"></i>
                    </button>
                    <div class="p-4 bg-gray-50 text-sm text-gray-600 border-t border-gray-200">
                        Сроки зависят от сложности объекта, но обычно стандартный монтаж занимает 2-3 часа.
                    </div>
                </div>
                <!-- FAQ Item 3 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 transition text-left">
                        <span class="font-medium text-gray-700 text-sm">Даете ли гарантию на оборудование?</span>
                        <i class="fa-solid fa-chevron-down text-primary text-xs"></i>
                    </button>
                </div>
                 <!-- FAQ Item 4 -->
                 <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 transition text-left">
                        <span class="font-medium text-gray-700 text-sm">Где посмотреть прайс?</span>
                        <i class="fa-solid fa-chevron-down text-primary text-xs"></i>
                    </button>
                </div>
                 <!-- FAQ Item 5 -->
                 <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 transition text-left">
                        <span class="font-medium text-gray-700 text-sm">Как выбрать кондиционер, доверьте нашим менеджерам?</span>
                        <i class="fa-solid fa-chevron-down text-primary text-xs"></i>
                    </button>
                </div>
                 <!-- FAQ Item 6 -->
                 <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 transition text-left">
                        <span class="font-medium text-gray-700 text-sm">Можно ли оплатить сразу при получении товара?</span>
                        <i class="fa-solid fa-chevron-down text-primary text-xs"></i>
                    </button>
                </div>
                 <!-- FAQ Item 7 -->
                 <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 transition text-left">
                        <span class="font-medium text-gray-700 text-sm">Живу за городом, какая цена за километр?</span>
                        <i class="fa-solid fa-chevron-down text-primary text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-[1200px]">
            <div class="bg-blue-100 rounded-2xl p-8 lg:p-12 flex flex-col lg:flex-row items-center justify-between relative overflow-hidden">
                <div class="w-full lg:w-1/2 z-10 mb-8 lg:mb-0">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Остались вопросы?</h2>
                    <p class="text-gray-600 mb-8 text-sm max-w-md">
                        Заполните форму и наши менеджеры свяжутся с вами в ближайшее время для консультации.
                    </p>
                    <form class="space-y-4 max-w-md">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <input type="text" placeholder="Ваше имя" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-primary text-sm">
                            <input type="tel" placeholder="+375 (__) ___-__-__" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-primary text-sm">
                        </div>
                        <input type="text" placeholder="Ваш вопрос" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-primary text-sm">
                        
                        <div class="flex items-start gap-2">
                            <input type="checkbox" id="policy" class="mt-1">
                            <label for="policy" class="text-xs text-gray-500">
                                Я согласен на обработку персональных данных
                            </label>
                        </div>

                        <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-3 px-8 rounded transition shadow-lg shadow-blue-500/30 text-sm w-full sm:w-auto">
                            ОТПРАВИТЬ
                        </button>
                    </form>
                </div>
                <div class="w-full lg:w-1/3 relative z-10">
                     <!-- Placeholder for AC Image -->
                     <img src="https://placehold.co/400x300/dbeafe/1d63cc?text=AC+Unit" alt="AC" class="w-full h-auto object-contain">
                </div>
                <!-- Background decorative -->
                <div class="absolute right-0 bottom-0 w-2/3 h-full bg-gradient-to-l from-blue-200/50 to-transparent rounded-full transform translate-x-1/3 translate-y-1/3"></div>
            </div>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer();
