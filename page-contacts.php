<?php
/**
 * Template Name: Contacts Page
 * 
 * @package torg-vent-brest
 */

get_header();

// Helper
if (!function_exists('tvb_get_field')) {
    function tvb_get_field($key, $default = '') {
        if (function_exists('get_field')) {
            $val = get_field($key);
            return $val ? $val : $default;
        }
        return $default;
    }
}

// Data from ACF
$phone = tvb_get_field('contacts_phone', '+375-33-916-66-62');
$phone2 = tvb_get_field('contacts_phone_2', '+375-33-916-66-67');
$email = tvb_get_field('contacts_email', 'Torg_vent@mail.ru');
$address = tvb_get_field('contacts_address', 'г.Брест, ул.Пионерская, 85 офис 11');
$schedule = tvb_get_field('contacts_schedule', "пн-пт - с 9:00 до 17:00\nсб - с 9:00 до 14:00\nвс - выходной");
$map_iframe = tvb_get_field('contacts_map_iframe');
if (!$map_iframe) {
    // Default Map
    $map_iframe = '<iframe src="https://yandex.ru/map-widget/v1/?ll=23.730579%2C52.095253&z=17&pt=23.730579,52.095253,pm2blm" width="100%" height="100%" frameborder="0" allowfullscreen="true"></iframe>';
}

// Image syncing from Installation Page
$install_pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-installation.php',
    'number' => 1
));
$contact_image = (!empty($install_pages)) ? get_field('contact_image', $install_pages[0]->ID) : '';

// Form texts
$form_title = 'Остались вопросы?';
$form_desc = 'Оставьте ваши контактные данные. Проконсультируем по всем интересующим вопросам.';
$footer_text = 'Позвоните нам или напишите';
?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 max-w-[1240px] py-6">
        
        <!-- Breadcrumbs -->
        <div class="text-xs text-gray-500 mb-8">
            <a href="<?php echo home_url(); ?>" class="hover:text-primary transition">Главная</a>
            <span class="mx-1 text-primary">/</span>
            <span class="text-primary">Контакты</span>
        </div>

        <h1 class="text-3xl md:text-[36px] font-bold text-gray-800 text-center mb-12 tracking-wide">
            Контакты
        </h1>

        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 mb-20 items-start">
            <!-- Left: Info -->
            <div class="lg:w-1/3 space-y-6 pt-4">
                
                <!-- Phone 1 with Socials -->
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-phone text-[#1E65C6] text-xl w-6 text-center"></i>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>" class="text-[16px] font-medium text-gray-800 hover:text-primary transition whitespace-nowrap">
                            <?php echo esc_html($phone); ?>
                        </a>
                        <!-- Socials -->
                        <div class="flex gap-2">
                            <a href="viber://chat?number=<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>" class="w-8 h-8 bg-[#7B519D] rounded flex items-center justify-center text-white hover:opacity-80 transition">
                                <i class="fa-brands fa-viber text-sm"></i>
                            </a>
                            <a href="https://t.me/+375339166667" target="_blank" class="w-8 h-8 bg-[#2AABEE] rounded flex items-center justify-center text-white hover:opacity-80 transition">
                                <i class="fa-brands fa-telegram text-sm"></i>
                            </a>
                            <a href="https://wa.me/375339166667" target="_blank" class="w-8 h-8 bg-[#25D366] rounded flex items-center justify-center text-white hover:opacity-80 transition">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Phone 2 -->
                <?php if($phone2): ?>
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-phone text-[#1E65C6] text-xl w-6 text-center"></i>
                    <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone2); ?>" class="text-[16px] font-medium text-gray-800 hover:text-primary transition">
                        <?php echo esc_html($phone2); ?>
                    </a>
                </div>
                <?php endif; ?>

                <!-- Schedule -->
                 <div class="flex items-start gap-4 mt-6">
                    <i class="fa-solid fa-clock text-[#1E65C6] text-xl w-6 text-center mt-1"></i>
                    <div class="text-[16px] text-gray-800 leading-snug font-medium">
                        <?php echo nl2br(esc_html($schedule)); ?>
                    </div>
                </div>

                <!-- Email -->
                 <div class="flex items-center gap-4 mt-2">
                    <i class="fa-solid fa-envelope text-[#1E65C6] text-xl w-6 text-center"></i>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="text-[20px] font-medium text-gray-800 hover:text-primary transition">
                        <?php echo esc_html($email); ?>
                    </a>
                </div>

                <!-- Address -->
                 <div class="flex items-start gap-4 mt-2">
                    <i class="fa-solid fa-location-dot text-[#1E65C6] text-xl w-6 text-center mt-1"></i>
                    <div class="text-[16px] text-gray-800 font-medium leading-tight">
                        <?php echo esc_html($address); ?>
                    </div>
                </div>

            </div>

            <!-- Right: Map -->
            <div class="lg:w-2/3 w-full h-[400px] md:h-[500px] bg-gray-100 rounded-[8px] overflow-hidden shadow-sm relative">
                <?php echo $map_iframe; ?>
            </div>
        </div>

        <!-- Form -->
        <?php get_template_part('template-parts/section', 'consultation-form', array(
            'title' => $form_title,
            'desc' => $form_desc,
            'image' => $contact_image,
            'footer_text' => $footer_text,
            'form_id' => 'contacts-page-form',
            'message_id' => 'form-message-contacts',
        )); ?>

    </div>
</main>

<style>
    /* Ensure iframe inside map container takes full size */
    .lg\:w-2\/3 iframe {
        width: 100% !important;
        height: 100% !important;
        min-height: 400px;
    }
</style>

<?php
get_footer();
