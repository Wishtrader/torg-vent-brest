<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package torg-vent-brest
 */

?>

    <footer id="colophon" class="site-footer bg-[#264477] text-white pt-12 pb-6 mt-auto">
        <div class="container mx-auto px-4 max-w-[1200px]">
            
            <!-- Top Footer Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                
                <!-- Column 1: Brand & Policy -->
                <div class="flex flex-col">
                    <h2 class="text-2xl font-bold mb-8 text-white">БрестКлимат.Бай</h2>
                    <div class="flex flex-col gap-2 text-sm text-gray-300">
                        <a href="<?php echo home_url('/cookie-policy'); ?>" class="hover:text-white transition">Политика обработки файлов cookie</a>
                        <a href="<?php echo home_url('/privacy-policy'); ?>" class="hover:text-white transition">Согласие на обработку персональных данных</a>
                    </div>
                </div>

                <!-- Column 2: Menu 1 -->
                <div class="flex flex-col">
                    <h3 class="text-lg font-semibold mb-6">Меню</h3>
                    <ul class="flex flex-col gap-3 text-sm text-gray-200">
                        <li><a href="#" class="hover:text-white transition">Каталог</a></li>
                        <li><a href="#" class="hover:text-white transition">Услуги</a></li>
                        <li><a href="#" class="hover:text-white transition">Отзывы</a></li>
                        <li><a href="#" class="hover:text-white transition">Портфолио</a></li>
                    </ul>
                </div>

                <!-- Column 3: Menu 2 -->
                <div class="flex flex-col pt-0 lg:pt-[52px]"> <!-- Align with menu items of col 2 -->
                    <ul class="flex flex-col gap-3 text-sm text-gray-200">
                        <li><a href="#" class="hover:text-white transition">Оплата и доставка</a></li>
                        <li><a href="#" class="hover:text-white transition">О компании</a></li>
                        <li><a href="#" class="hover:text-white transition">Контакты</a></li>
                    </ul>
                </div>

                <!-- Column 4: Contacts -->
                <div class="flex flex-col text-right items-end">
                    <h3 class="text-lg font-semibold mb-6">Контакты</h3>
                    <div class="flex flex-col gap-3 text-sm text-gray-200 items-end">
                        <a href="tel:+375339166662" class="flex items-center gap-2 hover:text-white transition">
                            <i class="fa-solid fa-phone text-white text-xs"></i>
                            +375-33-916-66-62
                        </a>
                        <div class="flex gap-2 my-1">
                            <a href="viber://chat?number=%2B375339166662" class="bg-[#7B519D] p-1.5 rounded text-white hover:opacity-80 transition">
															<img src="<?php echo get_template_directory_uri(); ?>/assets/images/viber.svg" alt="Viber">
														</a>
                            <a href="https://t.me/+375339166667" class="bg-[#2AABEE] p-1.5 rounded text-white hover:opacity-80 transition">
															<img src="<?php echo get_template_directory_uri(); ?>/assets/images/tg.svg" alt="Telegram">
														</a>
                            <a href="https://wa.me/375339166662" class="bg-[#25D366] p-1.5 rounded text-white hover:opacity-80 transition">
															<img src="<?php echo get_template_directory_uri(); ?>/assets/images/wu.svg" alt="WhatsApp">
														</a>
                        </div>
                        <a href="tel:+375339166667" class="flex items-center gap-2 hover:text-white transition">
                            <i class="fa-solid fa-phone text-white text-xs"></i>
                            +375-33-916-66-67
                        </a>
                        <div class="text-white text-xs mt-2">
                            <p>пн-пт - с 9:00 до 17:00</p>
                            <p>сб - с 9:00 до 14:00</p>
                            <p class="text-gray-300">вс - выходной</p>
                        </div>
                        <a href="mailto:Torg_vent@mail.ru" class="mt-2 hover:text-white transition">Torg_vent@mail.ru</a>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-[#DEDEDE]/60 mb-4"></div>

            <!-- Bottom Footer Section -->
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 text-[10px] text-white">
                
                <!-- Copyright & Legal -->
                <div class="max-w-2xl">
                    <p class="mb-1">© 2025 Общество с ограниченной ответственностью "ТоргВентБрест", интернет-магазин www.brestklimat.by, Torg_vent@mail.ru</p>
                    <p class="mb-1">ООО "ТоргВентБрест", © 2025. Зарегистрировано <span class="text-red-500">Минским городским исполнительным комитетом №970 от 31.08.2000г.</span></p>
                    <p>УНП 291864371. Регистрация в Торговом реестре Республики Беларусь <span class="text-red-500">№210825 04.03.2015г.</span></p>
                </div>

                <!-- Payment Icons -->
                <div class="flex items-center gap-4">
                    <i class="fa-brands fa-cc-visa text-2xl text-white"></i>
                    <i class="fa-brands fa-cc-mastercard text-2xl text-white"></i>
                    <!-- Placeholders for local payment systems -->
                    <span class="font-bold text-white">БЕЛКАРТ</span>
                    <span class="font-bold text-white text-[#e6b12e]">bePaid</span>
                    <span class="font-bold text-white">Оплати</span>
                </div>
            </div>
						<div class="border-t border-[#DEDEDE]/60 mb-4 mt-4"></div>
            
             <!-- Bottom Legal 2 -->
             <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 text-[10px] text-white mt-6">
                <div class="max-w-xl">
                    <p>Контакты для обращения покупателей (по вопросам нарушения их прав):</p>
                    <p>+37533-916-66-62, Torg_vent@mail.ru</p>
                </div>
                <div class="text-right">
                    <p>Телефон уполномоченных по защите прав потребителей:</p>
                    <p class="text-red-500">+375 17 280 54 65 – администрация Первомайского района г.Минска</p>
                </div>
             </div>

        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->


<!-- Cookie Consent -->
<div id="cookie-banner" class="fixed bottom-0 left-0 w-full bg-white shadow-[0_-5px_15px_rgba(0,0,0,0.1)] z-[9999] p-4 py-6 transform translate-y-full transition-transform duration-500 ease-in-out border-t border-gray-100 hidden font-sans">
    <div class="container mx-auto max-w-[1240px] flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="text-sm text-gray-700 leading-relaxed font-normal md:max-w-3xl text-center md:text-left">
            Для удобства пользователей сайта используются файлы cookie. Продолжая просмотр этого сайта, вы соглашаетесь на обработку файлов cookie в соответствии с <a href="<?php echo home_url('/cookie-policy'); ?>" class="text-[#1E65C6] hover:text-[#0a4b9c] transition underline decoration-1 underline-offset-2">Политикой обработки файлов cookie</a>
        </div>
        <div class="flex gap-4 flex-shrink-0 flex-col sm:flex-row w-full sm:w-auto">
            <button id="cookie-accept" class="bg-[#1E65C6] hover:bg-[#1553a8] text-white font-bold py-2.5 px-8 rounded text-[13px] uppercase tracking-wide transition shadow-md w-full sm:w-auto hover:shadow-lg">
                ПРИНЯТЬ
            </button>
            <button id="cookie-decline" class="bg-white border text-[#1E65C6] border-[#1E65C6] hover:bg-blue-50 font-bold py-2.5 px-8 rounded text-[13px] uppercase tracking-wide transition w-full sm:w-auto">
                ОТКЛОНИТЬ
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const banner = document.getElementById('cookie-banner');
    const acceptBtn = document.getElementById('cookie-accept');
    const declineBtn = document.getElementById('cookie-decline');

    if (!banner || !acceptBtn || !declineBtn) return;

    // Helper functions
    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            const date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for(let i=0;i < ca.length;i++) {
            let c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    function showBanner() {
        banner.classList.remove('hidden');
        // Force reflow
        void banner.offsetWidth;
        banner.classList.remove('translate-y-full');
    }

    function hideBanner() {
        banner.classList.add('translate-y-full');
        setTimeout(() => {
            banner.classList.add('hidden');
        }, 500);
    }

    // Logic
    const consent = getCookie('cookie_consent');

    if (!consent) {
        // Show if no cookie exists (neither accepted nor declined-session)
        // Delay slightly for UX
        setTimeout(showBanner, 1000);
    }

    acceptBtn.addEventListener('click', () => {
        // Accept: Persistent cookie (1 year)
        setCookie('cookie_consent', 'accepted', 365);
        hideBanner();
    });

    declineBtn.addEventListener('click', () => {
        // Decline: Session cookie (expires on browser close)
        // This ensures it appears again on next "visit" (next session)
        setCookie('cookie_consent', 'declined', null);
        hideBanner();
    });
});
</script>

<?php wp_footer(); ?>

</body>
</html>
