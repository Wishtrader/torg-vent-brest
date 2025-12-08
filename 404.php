<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package torg-vent-brest
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="py-20 md:py-32 min-h-[70vh] flex flex-col items-center justify-center text-center">
        <div class="container mx-auto px-4 max-w-[1200px]">
            
            <h1 class="lg:text-[36px] md:text-3xl font-bold text-gray-800 mb-6">
                Страница не найдена
            </h1>

            <div class="text-[120px] md:text-[240px] leading-none font-bold text-[#29ABE2] mb-8">
                404
            </div>

            <p class="text-[16px] text-gray-600 mb-12 max-w-2xl mx-auto">
                Неправильно введен адрес или такой страницы не существует
            </p>

            <a href="<?php echo home_url(); ?>" class="main-button font-bold text-white py-4 px-12 rounded shadow-lg shadow-blue-500/30 transition uppercase tracking-wide">
                НА ГЛАВНУЮ
            </a>

        </div>
    </section>
</main>

<?php
get_footer();
