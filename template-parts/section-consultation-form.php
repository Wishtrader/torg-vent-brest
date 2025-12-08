<?php
/**
 * Template part for displaying consultation/contact form
 *
 * @package torg-vent-brest
 */

$defaults = array(
    'title' => 'Остались вопросы?',
    'desc' => 'Оставьте ваши контактные данные. Проконсультируем по всем интересующим вопросам и поможем подобрать климатическую технику',
    'image' => '',
    'btn_text' => 'ОТПРАВИТЬ',
    'footer_text' => 'Позвоните нам или напишите',
    'form_id' => 'consultation-form-element',
    'message_id' => 'form-message',
);

$args = wp_parse_args($args ?? array(), $defaults);
?>

<div id="consultation-section-<?php echo esc_attr($args['form_id']); ?>" class="relative rounded-[8px] overflow-hidden bg-gradient-to-r from-[#C1DCE8] to-[#B3D6E6] p-8 md:p-12 mb-20 min-h-[496px] flex items-center shadow-lg">
    
    <div class="relative z-10 w-full">
        <h2 class="text-[36px] font-bold text-gray-800 mb-4 tracking-tight">
            <?php echo esc_html($args['title']); ?>
        </h2>
        <p class="text-[16px] text-gray-600 mb-8 md:max-w-[55%]">
            <?php echo esc_html($args['desc']); ?>
        </p>

        <form id="<?php echo esc_attr($args['form_id']); ?>" class="space-y-4 md:max-w-[77%]">
            <div class="flex gap-4">
                <input type="text" name="name" placeholder="Ваше имя*" required class="w-1/2 px-4 py-3 rounded bg-white border-none focus:ring-2 focus:ring-primary outline-none shadow-sm text-sm">
                <input type="tel" name="phone" placeholder="Телефон*" required class="w-1/2 px-4 py-3 rounded bg-white border-none focus:ring-2 focus:ring-primary outline-none shadow-sm text-sm">
            </div>
            <input type="text" name="question" placeholder="Вопрос" class="w-full px-4 py-3 rounded bg-white border-none focus:ring-2 focus:ring-primary outline-none shadow-sm text-sm">
            
            <div class="flex items-start gap-2 text-xs text-gray-500 my-[60px]">
                <input type="checkbox" id="consent-<?php echo esc_attr($args['form_id']); ?>" required class="mt-0.5">
                <label for="consent-<?php echo esc_attr($args['form_id']); ?>" class="text-[16px]">Согласен (а) на обработку персональных данных</label>
            </div>

            <button type="submit" class="main-button md:text-[16px] md:w-[300px] text-white font-bold py-3 rounded shadow-lg shadow-gray-500/50 transition uppercase text-xs tracking-wider">
                <?php echo esc_html($args['btn_text']); ?>
            </button>

            <div id="<?php echo esc_attr($args['message_id']); ?>" class="hidden text-sm mt-2"></div>
        </form>

        <div class="mt-8 flex flex-col items-start md:items-end gap-4 text-gray-700 font-medium text-[16px] absolute bottom-0 right-0">
            <span><?php echo esc_html($args['footer_text']); ?></span>
            <div class="flex">
                <div class="flex items-center gap-2 mr-[10px]">
                    <i class="fa-solid fa-phone text-[#4A86C8]"></i>
                    <a href="tel:+375339166662" class="hover:text-primary transition font-bold md:text-[20px]">+375-33-916-66-62</a>
                </div>
                <div class="flex gap-2">
                    <a href="viber://chat?number=%2B375339166662" class="hover:opacity-80 transition" title="Написать в Viber">
                        <img class="w-[36px]" src="<?php echo get_template_directory_uri(); ?>/assets/images/viber.svg" alt="Viber">
                    </a>
                    <a href="https://t.me/+375339166667" target="_blank" class="hover:opacity-80 transition" title="Написать в Telegram">
                        <img class="w-[36px]" src="<?php echo get_template_directory_uri(); ?>/assets/images/tg.svg" alt="Telegram">
                    </a>
                    <a href="https://wa.me/375339166667" target="_blank" class="hover:opacity-80 transition mr-[14px]" title="Написать в WhatsApp">
                        <img class="w-[36px]" src="<?php echo get_template_directory_uri(); ?>/assets/images/wu.svg" alt="WhatsApp">
                    </a>    
                </div>
            </div>
        </div>
    </div>

    <!-- Image Absolute -->
    <div class="hidden md:block absolute right-0 bottom-0 -top-[50px] w-1/3 h-full">
        <?php if ($args['image']) : ?>
                <img src="<?php echo esc_url($args['image']); ?>" alt="Кондиционер" class="w-full h-full object-contain object-right-bottom drop-shadow-2xl scale-125 origin-bottom-right">
        <?php else : ?>
                <!-- SVG Placeholder -->
                <div class="w-full h-full flex items-end justify-end opacity-20">
                    <i class="fa-regular fa-snowflake text-[300px] text-white"></i>
                </div>
        <?php endif; ?>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const formId = '<?php echo esc_js($args['form_id']); ?>';
    const msgId = '<?php echo esc_js($args['message_id']); ?>';
    
    const form = document.getElementById(formId);
    if(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = form.querySelector('button[type="submit"]');
            const msg = document.getElementById(msgId);
            const originalText = btn.innerText;
            
            btn.innerText = 'ОТПРАВКА...';
            btn.disabled = true;
            
            const formData = new FormData(this);
            formData.append('action', 'send_question');
            formData.append('nonce', '<?php echo wp_create_nonce('consultation_nonce'); ?>');
            
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    btn.innerText = 'ОТПРАВЛЕНО';
                    btn.classList.replace('bg-[#4A86C8]', 'bg-green-600');
                    msg.textContent = data.data.message;
                    msg.classList.remove('hidden', 'text-red-500');
                    msg.classList.add('text-green-700');
                    form.reset();
                    // Re-enable button after 3 seconds or keep it?
                    setTimeout(() => {
                         btn.innerText = originalText;
                         btn.disabled = false;
                         btn.classList.replace('bg-green-600', 'bg-[#4A86C8]');
                         msg.classList.add('hidden');
                    }, 5000);
                } else {
                    btn.innerText = originalText;
                    btn.disabled = false;
                    msg.textContent = data.data.message;
                    msg.classList.remove('hidden');
                    msg.classList.add('text-red-500');
                }
            })
            .catch(error => {
                console.error(error);
                btn.innerText = originalText;
                btn.disabled = false;
            });
        });
    }
});
</script>
