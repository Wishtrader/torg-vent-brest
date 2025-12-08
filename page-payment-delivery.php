<?php
/**
 * Template Name: Payment and Delivery Page
 * 
 * @package torg-vent-brest
 */

get_header();

// Helper (if not globally available)
if (!function_exists('tvb_get_field')) {
    function tvb_get_field($key, $default = '') {
        if (function_exists('get_field')) {
            $val = get_field($key);
            return $val ? $val : $default;
        }
        return $default;
    }
}

// Data
$payment_title = tvb_get_field('pd_payment_title', 'СПОСОБЫ ОПЛАТЫ');
$payment_text = tvb_get_field('pd_payment_text', 'Вы можете оплатить покупку любым удобным способом. Мы принимаем наличные средства при получении оборудования или после выполнения монтажных работ. Также доступна оплата банковскими картами Visa, Mastercard и МИР – онлайн при оформлении заказа или через терминал во время доставки. Для организаций предусмотрен безналичный расчет с выставлением счета. Все платежи осуществляются безопасно, с предоставлением полного пакета документов.');

$delivery_title = tvb_get_field('pd_delivery_title', 'УСЛОВИЯ ДОСТАВКИ');
$delivery_text = tvb_get_field('pd_delivery_text', '<p>Все условия доставки согласовываются индивидуально с каждым клиентом. Мы доставляем технику строго в оговоренные сроки к месту будущего монтажа. При заказе установки кондиционера в черте города действует бесплатная доставка. В случае необходимости срочной доставки в день заказа, мы постараемся выполнить ваш запрос при наличии оборудования на складе.</p><p>Мы гарантируем бережную транспортировку техники и обязательную проверку оборудования перед установкой. Для корпоративных клиентов предусмотрены индивидуальные условия сотрудничества.</p>');

$contact_title = tvb_get_field('pd_contact_title', 'Остались вопросы?');
$contact_desc = tvb_get_field('pd_contact_desc', 'Оставьте ваши контактные данные. Проконсультируем по всем интересующим вопросам и поможем подобрать климатическую технику');
// Fetch image from Installation Page to keep it in sync
$install_pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-installation.php',
    'number' => 1
));
$contact_image = (!empty($install_pages)) ? get_field('contact_image', $install_pages[0]->ID) : '';
$form_btn_text = tvb_get_field('pd_form_btn_text', 'ОТПРАВИТЬ');
$contact_footer_text = tvb_get_field('pd_contact_footer_text', 'Позвоните нам или напишите');
?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 max-w-[1240px] py-6">
        
        <!-- Breadcrumbs -->
        <div class="text-xs text-gray-500 mb-8">
            <a href="<?php echo home_url(); ?>" class="hover:text-primary transition">Главная</a>
            <span class="mx-1 text-primary">/</span>
            <span class="text-primary">Оплата и доставка</span>
        </div>

        <!-- H1 Main Title -->
        <h1 class="text-3xl md:text-[36px] font-bold text-gray-800 text-center mb-12 tracking-wide">
            Оплата и доставка
        </h1>

        <!-- Content Section -->
        <div class="mx-auto mb-20 space-y-12">
            
            <!-- Payment Block -->
            <div class="bg-transparent">
                <h2 class="text-xl font-bold text-gray-800 uppercase mb-4 tracking-tight">
                    <?php echo esc_html($payment_title); ?>
                </h2>
                <div class="text-sm text-gray-600 md:text-[16px] leading-relaxed font-normal text-justify md:text-left">
                    <?php echo wp_kses_post($payment_text); ?>
                </div>
            </div>

            <!-- Delivery Block -->
            <div class="bg-transparent">
                <h2 class="text-xl font-bold text-gray-800 uppercase mb-4 tracking-tight">
                    <?php echo esc_html($delivery_title); ?>
                </h2>
                <div class="text-sm md:text-[16px] text-gray-600 leading-relaxed font-normal space-y-4 text-justify md:text-left">
                    <?php echo wp_kses_post($delivery_text); ?>
                </div>
            </div>

        </div>

        <!-- Contact Section (Reused Design) -->
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



<?php
get_footer();
