<?php
/**
 * Template Name: Installation Page
 * 
 * @package torg-vent-brest
 */

get_header();

// Helper to safely get field with fallback
function tvb_get_field($key, $default = '') {
    if (function_exists('get_field')) {
        $val = get_field($key);
        return $val ? $val : $default;
    }
    return $default;
}

// Data extraction
$install_title = tvb_get_field('install_title', 'Монтаж систем кондиционирования и вентиляции');
$install_subtitle = tvb_get_field('install_subtitle', 'ВАШ КЛИМАТИЧЕСКИЙ КОМФОРТ — НАША ПРОФЕССИОНАЛЬНАЯ УСТАНОВКА');
$install_desc = tvb_get_field('install_desc', 'С 2020 года мы создаем идеальный микроклимат там, где это важно: в уютных квартирах, динамичных офисах и на ответственных промышленных объектах. Более 3000 успешных монтажей — это наше портфолио и ваша гарантия того, что каждый кондиционер будет работать безупречно.');
$install_features_title = tvb_get_field('install_features_title', 'ПОЧЕМУ С НАМИ УДОБНО И НАДЕЖНО:');
$install_features = tvb_get_field('install_features', '<p><strong>Четкость по графику:</strong> Мастер приедет точно в удобное для вас время, со всем необходимым.</p><p><strong>Решение «на месте»:</strong> Вместе мы определим лучшее место для установки, где кондиционер будет эффективно работать и гармонично впишется в интерьер.</p><p><strong>Прозрачный процесс:</strong> Вы будете знать все этапы: от крепления блоков и прокладки коммуникаций до вакуумирования и тестового запуска.</p><p><strong>Гарантия как уверенность:</strong> Мы несем ответственность за свою работу, поэтому предоставляем официальную гарантию на монтаж.</p>');
$intro_image = tvb_get_field('install_main_img'); 

$cta_text = tvb_get_field('cta_text', 'ДЛЯ ТОЧНОГО РАСЧЕТА СТОИМОСТИ ОСТАВЬТЕ ЗАЯВКУ И НАШ МЕНЕДЖЕР СВЯЖЕТСЯ С ВАМИ В ТЕЧЕНИЕ 15 МИНУТ ДЛЯ УТОЧНЕНИЯ ДЕТАЛЕЙ');
$cta_btn_text = tvb_get_field('cta_btn_text', 'УЗНАТЬ СТОИМОСТЬ');

$portfolio_title = tvb_get_field('portfolio_title', 'Примеры наших работ');

// Collect portfolio images (ACF Free compatibility)
$portfolio = array();
for ($i = 1; $i <= 8; $i++) {
    $img = tvb_get_field('portfolio_img_' . $i);
    if ($img) {
        $portfolio[] = $img;
    }
}

$contact_title = tvb_get_field('contact_title', 'Остались вопросы?');
$contact_desc = tvb_get_field('contact_desc', 'Оставьте ваши контактные данные. Проконсультируем по всем интересующим вопросам и поможем подобрать климатическую технику');
$contact_image = tvb_get_field('contact_image');
$form_btn_text = tvb_get_field('form_btn_text', 'ОТПРАВИТЬ');
$contact_footer_text = tvb_get_field('contact_footer_text', 'Позвоните нам или напишите');
?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 max-w-[1240px] py-6">
        
        <!-- Breadcrumbs -->
        <div class="text-sm text-gray-500 mb-8">
            <a href="<?php echo home_url(); ?>" class="hover:text-primary transition">Главная</a>
            <span class="mx-1 text-primary">/</span>
            <span class="text-primary">Монтаж</span>
        </div>

        <!-- Section 1: Intro -->
        <h1 class="text-3xl md:text-[32px] font-bold text-gray-800 text-center mb-12 tracking-wide">
            <?php echo esc_html($install_title); ?>
        </h1>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-16 mb-12">
            <!-- Left: Content -->
            <div class="lg:w-1/2">
                <h2 class="md:text-[20px] font-bold text-gray-800 mb-4 leading-tight">
                    <?php echo esc_html($install_subtitle); ?>
                </h2>
                <div class="text-[16px] text-gray-600 mb-6 leading-relaxed">
                    <?php echo wp_kses_post($install_desc); ?>
                </div>

                <h3 class="md:text-[20px] font-bold text-gray-800 uppercase mb-4">
                    <?php echo esc_html($install_features_title); ?>
                </h3>
                <div class="text-[16px] text-gray-600 space-y-3 leading-relaxed features-content">
                    <?php echo wp_kses_post($install_features); ?>
                </div>
            </div>

            <!-- Right: Image -->
            <div class="lg:w-1/2">
                <div class="rounded-[6px] overflow-hidden shadow-sm h-full max-h-[400px]">
                    <?php if ($intro_image) : ?>
                        <img src="<?php echo esc_url($intro_image); ?>" alt="Монтаж" class="w-full h-full object-cover">
                    <?php else : ?>
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                            <i class="fa-regular fa-image text-6xl"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- CTA Bar -->
        <div class="flex flex-col md:flex-row items-center gap-6 mb-20 bg-gray-50/50 py-4 rounded-lg">
            <button onclick="document.getElementById('consultation-form').scrollIntoView({behavior: 'smooth'})" class="main-button text-white md:min-w-[280px] font-bold py-3 px-8 rounded shadow-lg shadow-blue-500/30 transition uppercase text-sm whitespace-nowrap min-w-[200px]">
                <?php echo esc_html($cta_btn_text); ?>
            </button>
            <p class="text-sm md:text-[20px] max-w-[780px] font-bold text-gray-700 uppercase leading-snug">
                <?php echo esc_html($cta_text); ?>
            </p>
        </div>

        <!-- Section 2: Portfolio -->
        <div class="text-center mb-16">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8"><?php echo esc_html($portfolio_title); ?></h2>

            <div class="relative group px-4">
                <!-- Navigation Buttons -->
                <button id="slider-prev" class="absolute left-0 top-1/2 -translate-y-1/2 w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center z-10 opacity-80 hover:opacity-100 transition shadow-lg">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <button id="slider-next" class="absolute right-0 top-1/2 -translate-y-1/2 w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center z-10 opacity-80 hover:opacity-100 transition shadow-lg">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

                <!-- Scroll Container -->
                <div id="portfolio-slider" class="flex gap-4 overflow-x-auto snap-x snap-mandatory scrollbar-hide pb-4 -mx-4 px-4 scroll-smooth">
                    <?php if ($portfolio) : ?>
                        <?php foreach($portfolio as $img_url) : ?>
                            <div class="min-w-[280px] md:min-w-[300px] h-[300px] md:h-[350px] snap-center rounded-lg overflow-hidden shadow-md flex-shrink-0 relative bg-gray-100">
                                <img src="<?php echo esc_url($img_url); ?>" class="w-full h-full object-cover hover:scale-105 transition duration-500" alt="Work Example">
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <!-- Placeholders if empty -->
                        <?php for($i=1; $i<=4; $i++): ?>
                        <div class="min-w-[280px] md:min-w-[300px] h-[300px] md:h-[350px] snap-center rounded-lg overflow-hidden shadow-md flex-shrink-0 relative bg-gray-100 flex items-center justify-center">
                            <span class="text-gray-400">Пример <?php echo $i; ?></span>
                        </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Section 3: Contact Form -->
        <?php get_template_part('template-parts/section', 'consultation-form', array(
            'title' => $contact_title,
            'desc' => $contact_desc,
            'image' => $contact_image,
            'btn_text' => $form_btn_text,
            'footer_text' => $contact_footer_text,
            'form_id' => 'install-form',
            'message_id' => 'form-message',
        )); ?>

    </div>
</main>

<style>
    /* Custom features list styling using specific class */
    .features-content strong {
        color: #1f2937; /* gray-800 */
        font-weight: 700;
    }
    /* Hide scrollbar for slider */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Slider Logic
    const slider = document.getElementById('portfolio-slider');
    const prevBtn = document.getElementById('slider-prev');
    const nextBtn = document.getElementById('slider-next');

    // Smooth scroll amount
    const scrollAmount = 300;

    nextBtn.addEventListener('click', () => {
        slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });

    prevBtn.addEventListener('click', () => {
         slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });


});
</script>

<?php
get_footer();
