<?php
/**
 * Template Name: Order Success Page
 * 
 * @package torg-vent-brest
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="py-12 min-h-[60vh] flex flex-col">
        <div class="container mx-auto px-4 max-w-[1200px] flex-grow flex flex-col">
            
            <!-- Breadcrumbs -->
            <div class="mb-12 text-sm text-gray-500">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary transition">Главная</a>
                <span class="mx-2">/</span>
                <span class="text-primary">Заказ оформлен</span>
            </div>

            <div class="flex-grow flex flex-col items-center justify-center text-center max-w-4xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8">
                    Заказ оформлен
                </h1>

                <!-- Check Icon -->
                <div class="w-24 h-24 rounded-full border-4 border-green-500 flex items-center justify-center mb-8">
                    <i class="fa-solid fa-check text-5xl text-green-500"></i>
                </div>

                <!-- Success Message -->
                <p class="text-lg md:text-xl text-gray-800 font-bold mb-8 leading-relaxed">
                    Ваш заказ поступил в обработку, в ближайшее время с Вами свяжется менеджер для уточнения деталей!
                </p>

                <!-- Contacts -->
                <div class="mb-8">
                    <p class="text-gray-600 mb-4">
                        При возникновении вопросов вы можете связаться с нами по телефонам:
                    </p>
                    
                    <div class="flex flex-col items-center gap-3 font-medium text-gray-800">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-primary text-sm"></i>
                            <a href="tel:+375339166662" class="hover:text-primary transition">+375-33-916-66-62</a>
                            <div class="flex gap-2">
                                <a href="#" class="text-[#7B519D] hover:scale-110 transition"><i class="fa-brands fa-viber text-xl"></i></a>
                                <a href="#" class="text-[#24A1DE] hover:scale-110 transition"><i class="fa-brands fa-telegram text-xl"></i></a>
                                <a href="#" class="text-[#25D366] hover:scale-110 transition"><i class="fa-brands fa-whatsapp text-xl"></i></a>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-primary text-sm"></i>
                            <a href="tel:+375339166667" class="hover:text-primary transition">+375-33-916-66-67</a>
                        </div>
                    </div>
                </div>

                <!-- Home Button -->
                <a href="<?php echo home_url(); ?>" class="bg-[#5C9CE6] hover:bg-blue-600 text-white font-bold py-4 px-12 rounded shadow-lg shadow-blue-500/30 transition uppercase tracking-wide mt-4">
                    На главную
                </a>
            </div>

        </div>
    </section>
</main>

<?php
get_footer();
