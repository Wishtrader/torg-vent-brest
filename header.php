<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package torg-vent-brest
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts: Open Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico" type="image/x-icon">
    
    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Open Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: '#1864C8', // Matching the blue from the image
                    }
                }
            }
        }
    </script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site flex flex-col min-h-screen font-sans">
    
    <!-- Top Bar -->
    <div id="top-bar" class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 max-w-[1240px] py-2 flex flex-col md:flex-row justify-between items-center text-[16px] text-gray-600 font-medium">
            <div class="hidden md:block mb-2 md:mb-0 tracking-[0.01em]">
                Кондиционеры в Брестской и Гродненской области
            </div>
            <div class="flex flex-wrap justify-center md:justify-end items-center gap-4 md:gap-6 w-full md:w-auto">
                <a href="mailto:Torg_vent@mail.ru" class="flex items-center gap-2 hover:text-primary transition">
                    <i class="fa-solid fa-envelope text-primary"></i>
                    Torg_vent@mail.ru
                </a>
                <div class="flex items-center gap-[10px]">
                    <a href="tel:+375339166662" class="flex items-center gap-2 hover:text-primary transition text-[14px]">
                        <i class="fa-solid fa-phone text-primary"></i>
                        +375-33-916-66-62
                    </a>
                    <a href="viber://chat?number=%2B375339166662" class="hover:opacity-80 transition" title="Написать в Viber">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/viber.svg" alt="Viber">
                    </a>
										<a href="https://t.me/+375339166667" target="_blank" class="hover:opacity-80 transition" title="Написать в Telegram">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tg.svg" alt="Telegram">
                    </a>
                    <a href="https://wa.me/375339166667" target="_blank" class="hover:opacity-80 transition mr-[14px]" title="Написать в WhatsApp">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/wu.svg" alt="WhatsApp">
                    </a>
                    <a href="tel:+375339166667" class="flex items-center gap-2 hover:text-primary transition text-[14px]">
                        <i class="fa-solid fa-phone text-primary"></i>
                        +375-33-916-66-67
                    </a>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header id="masthead" class="site-header bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 max-w-[1240px] py-4 flex items-center justify-between">
            
            <!-- Logo -->
            <div class="site-branding flex-shrink-0 mr-4 lg:mr-[70px]">
                <?php
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-[18px] font-bold text-primary no-underline">
                        <p class="font-bold text-[18px] text-primary">БрестКлимат.Бай</p>
                    </a>
                    <?php
                }
                ?>
            </div>

            <!-- Catalog Button with Dropdown -->
            <div class="hidden md:block mr-4 lg:mr-8 relative group">
                <button class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-6 min-h-[44px] rounded-[8px] flex items-center gap-3 transition">
                    <i class="fa-solid fa-bars"></i>
                    КАТАЛОГ
                </button>
                
                <!-- Dropdown Menu -->
                <div class="absolute top-full left-0 mt-2 bg-white shadow-lg rounded-lg overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 min-w-[250px]">
                    <?php
                    $product_categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => false,
                    ));
                    
                    if (!empty($product_categories) && !is_wp_error($product_categories)) :
                        echo '<ul class="py-2">';
                        foreach ($product_categories as $category) :
                            $category_link = get_term_link($category);
                            $category_image = get_field('category_image', 'product_cat_' . $category->term_id);
                            ?>
                            <li>
                                <a href="<?php echo esc_url($category_link); ?>" class="block px-4 py-3 hover:bg-gray-50 transition text-gray-700 hover:text-primary no-underline">
                                    <span class="font-medium text-sm"><?php echo esc_html($category->name); ?></span>
                                </a>
                            </li>
                            <?php
                        endforeach;
                        echo '</ul>';
                    else :
                        echo '<div class="px-4 py-3 text-gray-500 text-sm">Категории не найдены</div>';
                    endif;
                    ?>
                </div>
            </div>

            <!-- Navigation -->
            <nav id="site-navigation" class="main-navigation hidden lg:flex flex-grow justify-center">
                <?php
                if ( has_nav_menu( 'menu-1' ) ) {
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                            'menu_class'     => 'flex gap-6 xl:gap-8 text-gray-700 font-medium text-sm list-none m-0 p-0',
                        )
                    );
                } else {
                    // Fallback links matching the image
                    echo '<ul class="flex gap-6 xl:gap-8 text-gray-700 font-medium text-sm list-none m-0 p-0">';
                    echo '<li><a href="' . home_url('/installation') . '" class="hover:text-primary text-[16px] transition no-underline text-gray-700">Монтаж</a></li>';
                    echo '<li><a href="' . home_url('/return-exchange') . '" class="hover:text-primary text-[16px] transition no-underline text-gray-700">Возврат и обмен</a></li>';
                    echo '<li><a href="' . home_url('/payment-delivery') . '" class="hover:text-primary text-[16px] transition no-underline text-gray-700">Оплата и доставка</a></li>';
                    echo '<li><a href="' . home_url('/contacts') . '" class="hover:text-primary text-[16px] transition no-underline text-gray-700">Контакты</a></li>';
                    echo '</ul>';
                }
                ?>
            </nav>

            <!-- User Actions -->
            <div class="flex items-center gap-4 md:gap-6 ml-auto">
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo home_url('/account'); ?>" class="flex items-center gap-2 text-gray-700 font-medium hover:text-primary transition no-underline" title="Личный кабинет">
                        <i class="fa-regular fa-user text-xl"></i>
                    </a>
                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="flex items-center gap-2 text-gray-700 font-medium hover:text-primary transition no-underline" title="Выход">
                        <i class="fa-solid fa-right-from-bracket text-xl"></i>
                    </a>
                <?php else : ?>
                    <a href="<?php echo home_url('/login'); ?>" class="flex items-center gap-2 text-gray-700 font-medium hover:text-primary transition no-underline">
                        <span class="hidden sm:inline text-[14px]">Войти</span>
                        <i class="fa-regular fa-user text-xl"></i>
                    </a>
                <?php endif; ?>
                <a href="<?php echo home_url('/cart'); ?>" class="relative text-gray-700 hover:text-primary transition" title="Корзина">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                    <?php 
                    $cart_count = get_cart_count();
                    ?>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white header-cart-count<?php echo $cart_count === 0 ? ' hidden' : ''; ?>"><?php echo $cart_count; ?></span>
                </a>
                
                <!-- Mobile Menu Button (Visible only on small screens) -->
                <button class="lg:hidden text-gray-700 text-2xl ml-2">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

        </div>
    </header><!-- #masthead -->
