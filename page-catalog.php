<?php
/**
 * Template Name: Catalog
 * 
 * The template for displaying the catalog page
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
                <span class="text-gray-800">Каталог</span>
            </nav>
        </div>
    </section>

    <!-- Page Title -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-[1200px]">
            <h1 class="text-4xl font-bold text-center text-gray-800 mb-12">Каталог</h1>
            
            <!-- Categories Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                // Get all product categories
                $product_categories = get_terms(array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => false,
                ));
                
                if (!empty($product_categories) && !is_wp_error($product_categories)) :
                    foreach ($product_categories as $category) :
                        $category_link = get_term_link($category);
                        $category_image = get_field('category_image', 'product_cat_' . $category->term_id);
                        ?>
                        <!-- Category Card -->
                        <a href="<?php echo esc_url($category_link); ?>" class="group bg-white rounded-lg p-6 shadow-sm hover:shadow-md border border-gray-100 transition text-center block no-underline">
                            <div class="h-48 flex items-center justify-center mb-4">
                                <?php if ($category_image) : ?>
                                    <img src="<?php echo esc_url($category_image['url']); ?>" alt="<?php echo esc_attr($category->name); ?>" class="max-h-full max-w-full object-contain group-hover:scale-110 transition">
                                <?php else : ?>
                                    <img src="https://placehold.co/200x200/f3f4f6/9ca3af?text=<?php echo urlencode(substr($category->name, 0, 15)); ?>" alt="<?php echo esc_attr($category->name); ?>" class="max-h-full group-hover:scale-110 transition">
                                <?php endif; ?>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 group-hover:text-primary transition"><?php echo esc_html($category->name); ?></h3>
                        </a>
                        <?php
                    endforeach;
                else :
                    ?>
                    <div class="col-span-full text-center text-gray-500 py-12">
                        <p class="text-lg">Категории товаров не найдены.</p>
                        <p class="text-sm mt-2">Добавьте категории в WordPress админ-панели.</p>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer();
