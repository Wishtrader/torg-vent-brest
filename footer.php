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

    <footer id="colophon" class="site-footer bg-[#264477] text-white pt-10 pb-8 mt-auto relative">
        <!-- Scroll To Top Button -->
        <button id="scroll-to-top" class="absolute top-6 right-4 lg:bottom-10 lg:top-auto lg:right-10 w-8 h-8 lg:w-10 lg:h-10 bg-white rounded-full flex items-center justify-center shadow-lg transition hover:bg-gray-100 z-10">
            <i class="fa-solid fa-arrow-up text-[#264477] text-sm lg:text-base"></i>
        </button>

        <div class="container mx-auto px-4 max-w-[1240px]">
            
            <!-- Main Top Section -->
            <div class="flex flex-col lg:flex-row lg:justify-between mb-8 lg:mb-12">
                
                <!-- Col 1: Brand & Policies -->
                <div class="flex flex-col mb-8 lg:mb-0 lg:w-1/4">
                    <h2 class="text-[22px] lg:text-[28px] font-bold mb-4 lg:mb-8 text-white">БрестКлимат.Бай</h2>
                    <div class="flex flex-col gap-2 text-[12px] lg:text-[13px] text-gray-200 lg:mt-auto">
                        <a href="<?php echo home_url('/cookie-policy'); ?>" class="hover:text-white transition">Политика обработки файлов cookie</a>
                        <a href="<?php echo home_url('/privacy-policy'); ?>" class="hover:text-white transition">Согласие на обработку персональных данных</a>
                    </div>
                </div>

                <!-- Col 2 & 3: Menu (Desktop Split, Mobile Grid) -->
                <div class="lg:w-1/2 flex flex-col lg:flex-row lg:justify-center lg:gap-12 xl:gap-24 mb-8 lg:mb-0">
                    <div class="hidden lg:block">
                        <h3 class="text-[16px] lg:text-[18px] font-bold mb-4 lg:mb-6">Меню</h3>
                        <div class="flex flex-col gap-3 text-[14px] lg:text-[15px]">
                            <a href="<?php echo home_url('/catalog'); ?>" class="hover:text-white transition">Каталог</a>
                            <a href="<?php echo home_url('/services'); ?>" class="hover:text-white transition">Услуги</a>
                            <a href="<?php echo home_url('/reviews'); ?>" class="hover:text-white transition">Отзывы</a>
                            <a href="<?php echo home_url('/portfolio'); ?>" class="hover:text-white transition">Портфолио</a>
                        </div>
                    </div>
                    
                    <!-- Mobile Menu Grid (Hidden on Desktop) -->
                    <div class="lg:hidden mb-8">
                        <h3 class="text-[16px] font-bold mb-4">Меню</h3>
                        <div class="grid grid-cols-2 gap-x-4 gap-y-3 text-[14px]">
                            <div class="flex flex-col gap-3">
                                <a href="<?php echo home_url('/catalog'); ?>" class="hover:text-white transition">Каталог</a>
                                <a href="<?php echo home_url('/services'); ?>" class="hover:text-white transition">Услуги</a>
                                <a href="<?php echo home_url('/reviews'); ?>" class="hover:text-white transition">Отзывы</a>
                                <a href="<?php echo home_url('/portfolio'); ?>" class="hover:text-white transition">Портфолио</a>
                            </div>
                            <div class="flex flex-col gap-3">
                                <a href="<?php echo home_url('/payment-delivery'); ?>" class="hover:text-white transition">Оплата и доставка</a>
                                <a href="<?php echo home_url('/about'); ?>" class="hover:text-white transition">О компании</a>
                                <a href="<?php echo home_url('/contacts'); ?>" class="hover:text-white transition">Контакты</a>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Menu Col 2 -->
                    <div class="hidden lg:block pt-[52px]"> <!-- Align with items -->
                        <div class="flex flex-col gap-3 text-[14px] lg:text-[15px]">
                            <a href="<?php echo home_url('/payment-delivery'); ?>" class="hover:text-white transition">Оплата и доставка</a>
                            <a href="<?php echo home_url('/about'); ?>" class="hover:text-white transition">О компании</a>
                            <a href="<?php echo home_url('/contacts'); ?>" class="hover:text-white transition">Контакты</a>
                        </div>
                    </div>
                </div>

                <!-- Col 4: Contacts -->
                <div class="flex flex-col lg:w-1/4 lg:items-end lg:text-right">
                    <h3 class="text-[16px] lg:text-[18px] font-bold mb-5 lg:mb-6">Контакты</h3>
                    <div class="flex flex-col gap-4 text-[15px] lg:items-end">
                        
                        <!-- Phone 1 and Messengers -->
                        <div class="flex flex-wrap lg:flex-nowrap items-center gap-3 lg:gap-4">
                            <a href="tel:+375339166662" class="flex items-center gap-3 hover:text-white transition whitespace-nowrap order-1 lg:order-1">
                                <i class="fa-solid fa-phone text-white text-sm transform rotate-90"></i>
                                <span>+375-33-916-66-62</span>
                            </a>
                            <!-- Messengers: On Desktop below phone? No, design shows separate block or same line. 
                                 Design: Phone line 1... then messengers below it? No, looking at image: 
                                 Phone... Messengers (Icons) are not strictly on same line in the mockup provided? 
                                 Actually in the mockup: Phone 1 is top right. Below it is Messengers row. Below is Phone 2. 
                                 Wait, the user said "Phone and Messengers in one row" in the prompt text? 
                                 Looking at user image: 
                                 Phone 1 (+375-33...)
                                 [Viber][Tg][WhatsApp] (Row below Phone 1)
                                 Phone 2 (+375-33...)
                            -->
                             <div class="flex gap-2 order-2 lg:order-2 lg:mt-1">
                                 <a href="viber://chat?number=%2B375339166662" class="w-7 h-7 bg-[#7B519D] rounded flex items-center justify-center hover:opacity-90 transition p-1">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/viber.svg" alt="Viber" class="w-full h-full object-contain">
                                </a>
                                <a href="https://t.me/+375339166667" class="w-7 h-7 bg-[#2AABEE] rounded flex items-center justify-center hover:opacity-90 transition p-1">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tg.svg" alt="Telegram" class="w-full h-full object-contain">
                                </a>
                                <a href="https://wa.me/375339166662" class="w-7 h-7 bg-[#25D366] rounded flex items-center justify-center hover:opacity-90 transition p-1">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/wu.svg" alt="WhatsApp" class="w-full h-full object-contain">
                                </a>
                            </div>
                        </div>

                        <!-- Phone 2 -->
                        <a href="tel:+375339166667" class="flex items-center gap-3 hover:text-white transition lg:flex-row-reverse">
                            <i class="fa-solid fa-phone text-white text-sm transform rotate-90"></i>
                            <span>+375-33-916-66-67</span>
                        </a>

                        <!-- Schedule -->
                        <div class="flex items-start gap-3 lg:flex-row-reverse lg:text-right">
                            <i class="fa-solid fa-clock text-white text-sm mt-1"></i>
                            <div class="leading-snug">
                                <p>пн-пт - с 9:00 до 17:00</p>
                                <p>сб - с 9:00 до 14:00</p>
                                <p class="text-gray-300">вс - выходной</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <a href="mailto:Torg_vent@mail.ru" class="hover:text-white transition pl-0 lg:text-base">
                             Torg_vent@mail.ru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-white/20 mb-6 lg:mb-8"></div>

            <!-- Bottom Section 1: Legal & Payment -->
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6 lg:gap-12 text-[11px] lg:text-[12px] opacity-90 mb-6 lg:mb-8">
                
                <!-- Legal Text -->
                <div class="leading-relaxed lg:max-w-3xl">
                    <p class="mb-1">© 2025 Общество с ограниченной ответственностью "ТоргВентБрест", интернет-магазин www.brestklimat.by, Torg_vent@mail.ru</p>
                    <p class="mb-1">OOO "ТоргВентБрест", © 2025. Зарегистрировано <span class="text-[#FF4D4D]">Минским городским исполнительным комитетом №970 от 31.08.2000г.</span></p>
                    <p>УНП 291864371. Регистрация в Торговом реестре Республики Беларусь <span class="text-[#FF4D4D]">№210825 04.03.2015г.</span></p>
                </div>

                <!-- Payment Icons -->
                <div class="flex flex-wrap items-center gap-4 lg:gap-6 flex-shrink-0">
                    <div class="flex items-center gap-1">
                         <i class="fa-brands fa-cc-visa text-2xl lg:text-3xl"></i>
                         <div class="flex flex-col text-[8px] leading-tight font-bold uppercase ml-1">
                             <span>Verified</span>
                             <span>By Visa</span>
                         </div>
                    </div>
                    
                    <div class="flex items-center gap-1">
                        <i class="fa-brands fa-cc-mastercard text-2xl lg:text-3xl"></i>
                         <div class="flex flex-col text-[8px] leading-tight font-bold uppercase ml-1">
                             <span>Mastercard</span>
                             <span>SecureCode</span>
                         </div>
                    </div>

                    <span class="text-[10px] lg:text-[12px] font-bold uppercase">БЕЛКАРТ</span>
                    <span class="text-[10px] lg:text-[12px] font-bold uppercase text-[#e6b12e]">bePaid</span>
                    <span class="text-[10px] lg:text-[12px] font-bold uppercase">Оплати</span>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-white/20 mb-6 lg:mb-8"></div>

            <!-- Bottom Legal 2 -->
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-end gap-6 text-[11px] lg:text-[12px] leading-relaxed opacity-90">
                <div class="lg:max-w-2xl">
                     <p>Контакты для обращения покупателей (по вопросам нарушения их прав): <span class="whitespace-nowrap font-semibold">+37533-916-66-62</span>, Torg_vent@mail.ru</p>
                </div>
                <div class="lg:text-right">
                    <p class="mb-1">Телефон уполномоченных по защите прав потребителей:</p>
                    <p class="text-[#FF4D4D] font-medium">+375 17 280 54 65 – администрация Первомайского района г.Минска</p>
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
    // Scroll To Top Logic
    const scrollBtn = document.getElementById('scroll-to-top');
    if(scrollBtn) {
        scrollBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Cookie Logic
    const banner = document.getElementById('cookie-banner');
    const acceptBtn = document.getElementById('cookie-accept');
    const declineBtn = document.getElementById('cookie-decline');

    if (!banner || !acceptBtn || !declineBtn) return;

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

    const consent = getCookie('cookie_consent');

    if (!consent) {
        setTimeout(showBanner, 1000);
    }

    acceptBtn.addEventListener('click', () => {
        setCookie('cookie_consent', 'accepted', 365);
        hideBanner();
    });

    declineBtn.addEventListener('click', () => {
        setCookie('cookie_consent', 'declined', null);
        hideBanner();
    });
});
</script>

<?php wp_footer(); ?>

</body>
</html>
