<?php
/**
 * Template Name: Return and Exchange Page
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
$re_title = tvb_get_field('re_main_title', 'УСЛОВИЯ ВОЗВРАТА И ОБМЕНА');
$re_text = tvb_get_field('re_main_text', '<p>Согласно Закону "О защите прав потребителей", вы можете вернуть или обменять товар надлежащего качества в течение 14 дней с момента покупки, если он не был в употреблении, сохранены его товарный вид, потребительские свойства, пломбы, фабричные ярлыки, а также имеется товарный чек или кассовый чек либо иной подтверждающий оплату указанного товара документ.</p><p>Обмену и возврату не подлежат товары надлежащего качества, входящие в Перечень непродовольственных товаров надлежащего качества, не подлежащих возврату или обмену на аналогичный товар, утвержденный Правительством.</p><p>В случае обнаружения недостатков товара, вы вправе потребовать: замены на товар этой же марки (этих же модели и (или) артикула); замены на такой же товар другой марки (модели, артикула) с соответствующим перерасчетом покупной цены; соразмерного уменьшения покупной цены; незамедлительного безвозмездного устранения недостатков товара или возмещения расходов на их исправление потребителем или третьим лицом; отказа от исполнения договора купли-продажи и возврата уплаченной за товар суммы.</p>');

// Image syncing
$install_pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-installation.php',
    'number' => 1
));
$contact_image = (!empty($install_pages)) ? get_field('contact_image', $install_pages[0]->ID) : '';

// Contact Form static texts (can be moved to ACF if needed, but per previous generic request kept static)
$contact_title = 'Остались вопросы?';
$contact_desc = 'Оставьте ваши контактные данные. Проконсультируем по всем интересующим вопросам и поможем с оформлением возврата';
$form_btn_text = 'ОТПРАВИТЬ';
$contact_footer_text = 'Позвоните нам или напишите';
?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 max-w-[1240px] py-6">
        
        <!-- Breadcrumbs -->
        <div class="text-xs text-gray-500 mb-8">
            <a href="<?php echo home_url(); ?>" class="hover:text-primary transition">Главная</a>
            <span class="mx-1 text-primary">/</span>
            <span class="text-primary">Возврат и обмен</span>
        </div>

        <!-- H1 Main Title -->
        <h1 class="text-3xl md:text-[36px] font-bold text-gray-800 text-center mb-12 tracking-wide">
            Возврат и обмен
        </h1>

        <!-- Content Section -->
        <div class="mx-auto mb-20 space-y-12">
            
            <!-- Main Block -->
            <div class="bg-transparent">
                <h2 class="text-xl font-bold text-gray-800 uppercase mb-4 tracking-tight">
                    <?php echo esc_html($re_title); ?>
                </h2>
                <div class="text-sm md:text-[16px] text-gray-600 leading-relaxed font-normal space-y-4 text-justify md:text-left">
                    <?php echo wp_kses_post($re_text); ?>
                </div>
            </div>

        </div>

        <!-- Contact Section (Reused Design) -->
        <?php get_template_part('template-parts/section', 'consultation-form', array(
            'title' => $contact_title,
            'desc' => $contact_desc,
            'image' => $contact_image,
            'btn_text' => $form_btn_text,
            'footer_text' => $contact_footer_text,
            'form_id' => 'return-exchange-form',
            'message_id' => 'form-message-re',
        )); ?>

    </div>
</main>

<?php
get_footer();
