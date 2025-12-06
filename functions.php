<?php
/**
 * torg-vent-brest functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package torg-vent-brest
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function torg_vent_brest_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on torg-vent-brest, use a find and replace
		* to change 'torg-vent-brest' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'torg-vent-brest', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'torg-vent-brest' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'torg_vent_brest_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'torg_vent_brest_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function torg_vent_brest_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'torg_vent_brest_content_width', 640 );
}
add_action( 'after_setup_theme', 'torg_vent_brest_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function torg_vent_brest_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'torg-vent-brest' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'torg-vent-brest' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'torg_vent_brest_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function torg_vent_brest_scripts() {
	wp_enqueue_style( 'torg-vent-brest-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'torg-vent-brest-style', 'rtl', 'replace' );

	wp_enqueue_script( 'torg-vent-brest-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'torg_vent_brest_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Product Setup (CPT, Taxonomy, ACF)
 */
require get_template_directory() . '/inc/product-setup.php';

/**
 * Handle Custom User Registration
 */
function handle_custom_user_registration() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'user_registration_nonce')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }

    // Get form data
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $password = $_POST['password'];

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        wp_send_json_error(array('message' => 'Пожалуйста, заполните все обязательные поля'));
        return;
    }

    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Неверный формат email'));
        return;
    }

    // Check if email already exists
    if (email_exists($email)) {
        wp_send_json_error(array('message' => 'Пользователь с таким email уже существует'));
        return;
    }

    // Create username from email
    $username = sanitize_user($email);

    // Create user
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        wp_send_json_error(array('message' => $user_id->get_error_message()));
        return;
    }

    // Update user meta
    wp_update_user(array(
        'ID' => $user_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'display_name' => $first_name . ' ' . $last_name
    ));

    // Add phone number to user meta
    update_user_meta($user_id, 'phone', $phone);

    // Auto login user
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);

    // Send success response
    wp_send_json_success(array(
        'message' => 'Регистрация успешна! Перенаправление...',
        'redirect_url' => home_url()
    ));
}
add_action('wp_ajax_nopriv_custom_user_registration', 'handle_custom_user_registration');
add_action('wp_ajax_custom_user_registration', 'handle_custom_user_registration');

/**
 * Handle Custom User Login
 */
function handle_custom_user_login() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'user_login_nonce')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }

    // Get form data
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];

    // Validate required fields
    if (empty($email) || empty($password)) {
        wp_send_json_error(array('message' => 'Пожалуйста, заполните все поля'));
        return;
    }

    // Validate email format
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Неверный формат email'));
        return;
    }

    // Get user by email
    $user = get_user_by('email', $email);

    if (!$user) {
        // Log for debugging
        error_log('Login attempt failed: User not found for email: ' . $email);
        wp_send_json_error(array('message' => 'Пользователь с таким email не найден'));
        return;
    }

    // Log user found
    error_log('User found: ID=' . $user->ID . ', Login=' . $user->user_login . ', Email=' . $user->user_email);

    // Check password directly first
    $password_check = wp_check_password($password, $user->user_pass, $user->ID);
    error_log('Password check result: ' . ($password_check ? 'true' : 'false'));

    if (!$password_check) {
        wp_send_json_error(array('message' => 'Неверный пароль'));
        return;
    }

    // Authenticate user using wp_signon
    $creds = array(
        'user_login'    => $user->user_login,
        'user_password' => $password,
        'remember'      => true
    );

    $user_signon = wp_signon($creds, false);

    if (is_wp_error($user_signon)) {
        error_log('wp_signon error: ' . $user_signon->get_error_message());
        wp_send_json_error(array('message' => 'Ошибка входа: ' . $user_signon->get_error_message()));
        return;
    }

    // Send success response
    wp_send_json_success(array(
        'message' => 'Вход выполнен успешно!',
        'redirect_url' => home_url('/account')
    ));
}
add_action('wp_ajax_nopriv_custom_user_login', 'handle_custom_user_login');
add_action('wp_ajax_custom_user_login', 'handle_custom_user_login');

/**
 * Redirect to home page after logout
 */
add_filter('logout_redirect', function($redirect_to, $requested_redirect_to, $user) {
    // If no specific redirect was requested, redirect to home
    if (empty($requested_redirect_to)) {
        return home_url();
    }
    return $requested_redirect_to;
}, 10, 3);

/**
 * Handle User Account Update
 */
function handle_update_user_account() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Необходимо войти в систему'));
        return;
    }
    
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'update_account_nonce')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }
    
    $user_id = get_current_user_id();
    
    // Get form data
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $street = sanitize_text_field($_POST['street']);
    $house = sanitize_text_field($_POST['house']);
    $entrance = sanitize_text_field($_POST['entrance']);
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
        wp_send_json_error(array('message' => 'Пожалуйста, заполните все обязательные поля'));
        return;
    }
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Неверный формат email'));
        return;
    }
    
    // Check if email is already used by another user
    $email_exists = email_exists($email);
    if ($email_exists && $email_exists != $user_id) {
        wp_send_json_error(array('message' => 'Этот email уже используется другим пользователем'));
        return;
    }
    
    // Update user data
    $user_data = array(
        'ID' => $user_id,
        'user_email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'display_name' => $first_name . ' ' . $last_name
    );
    
    // Update password if provided
    if (!empty($password)) {
        if (strlen($password) < 8) {
            wp_send_json_error(array('message' => 'Пароль должен содержать минимум 8 символов'));
            return;
        }
        $user_data['user_pass'] = $password;
    }
    
    $result = wp_update_user($user_data);
    
    if (is_wp_error($result)) {
        wp_send_json_error(array('message' => $result->get_error_message()));
        return;
    }
    
    // Update user meta
    update_user_meta($user_id, 'phone', $phone);
    update_user_meta($user_id, 'street', $street);
    update_user_meta($user_id, 'house', $house);
    update_user_meta($user_id, 'entrance', $entrance);
    
    // Send success response
    wp_send_json_success(array(
        'message' => 'Изменения успешно сохранены!'
    ));
}
add_action('wp_ajax_update_user_account', 'handle_update_user_account');

/**
 * Handle Toggle Favorite Product
 */
function handle_toggle_favorite() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Необходимо войти в систему'));
        return;
    }

    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'favorite_nonce')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }

    $product_id = intval($_POST['product_id']);
    $user_id = get_current_user_id();

    if (!$product_id) {
        wp_send_json_error(array('message' => 'Неверный ID товара'));
        return;
    }

    // Get current favorites
    $favorites = get_user_meta($user_id, 'favorite_products', true);
    if (!is_array($favorites)) {
        $favorites = array();
    }

    $action = '';
    
    // Toggle
    if (in_array($product_id, $favorites)) {
        // Remove
        $favorites = array_diff($favorites, array($product_id));
        $action = 'removed';
    } else {
        // Add
        $favorites[] = $product_id;
        $action = 'added';
    }

    // Save
    update_user_meta($user_id, 'favorite_products', array_values($favorites));

    wp_send_json_success(array(
        'action' => $action,
        'count' => count($favorites)
    ));
}
add_action('wp_ajax_toggle_favorite', 'handle_toggle_favorite');
add_action('wp_ajax_nopriv_toggle_favorite', 'handle_toggle_favorite');

/**
 * Handle Add to Cart
 */
function handle_add_to_cart() {
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Необходимо войти в систему', 'redirect' => home_url('/login')));
        return;
    }

    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'cart_nonce')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }

    $product_id = intval($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $user_id = get_current_user_id();

    if (!$product_id) {
        wp_send_json_error(array('message' => 'Неверный ID товара'));
        return;
    }

    $cart = get_user_meta($user_id, 'cart_items', true);
    if (!is_array($cart)) {
        $cart = array();
    }

    if (isset($cart[$product_id])) {
        $cart[$product_id] += $quantity;
    } else {
        $cart[$product_id] = $quantity;
    }

    update_user_meta($user_id, 'cart_items', $cart);

    $total_count = array_sum($cart);

    wp_send_json_success(array(
        'message' => 'Товар добавлен в корзину',
        'cart_count' => $total_count
    ));
}
add_action('wp_ajax_add_to_cart', 'handle_add_to_cart');

/**
 * Handle Update Cart Item
 */
function handle_update_cart_item() {
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Необходимо войти в систему'));
        return;
    }

    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'cart_nonce')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }

    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $user_id = get_current_user_id();

    $cart = get_user_meta($user_id, 'cart_items', true);
    if (!is_array($cart)) {
        $cart = array();
    }

    if ($quantity > 0) {
        $cart[$product_id] = $quantity;
    } else {
        unset($cart[$product_id]);
    }

    update_user_meta($user_id, 'cart_items', $cart);
    
    // Calculate new totals
    $cart_totals = calculate_cart_totals($user_id);

    wp_send_json_success(array(
        'message' => 'Корзина обновлена',
        'cart_count' => $cart_totals['count'],
        'cart_total' => $cart_totals['total'],
        'cart_discount' => $cart_totals['discount'],
        'cart_final' => $cart_totals['final']
    ));
}
add_action('wp_ajax_update_cart_item', 'handle_update_cart_item');

/**
 * Handle Remove from Cart
 */
function handle_remove_from_cart() {
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Необходимо войти в систему'));
        return;
    }

    // Reuse update logic with 0 quantity
    $_POST['quantity'] = 0;
    handle_update_cart_item();
}
add_action('wp_ajax_remove_from_cart', 'handle_remove_from_cart');

/**
 * Helper: Calculate Cart Totals
 */
function calculate_cart_totals($user_id) {
    $cart = get_user_meta($user_id, 'cart_items', true);
    if (!is_array($cart)) return array('count' => 0, 'total' => 0, 'discount' => 0, 'final' => 0);

    $count = 0;
    $total_price = 0;
    $total_discount = 0;

    foreach ($cart as $product_id => $qty) {
        $price = get_field('product_price', $product_id); // Assuming simple price field
        // If you have old price logic, implement it here
        // For now, let's assume 'price' is the final price
        // If you want discount calculation, we need 'product_old_price'
        
        $old_price = get_field('product_old_price', $product_id);
        
        $current_item_price = floatval($price);
        $current_item_old = floatval($old_price);
        
        if ($current_item_old > $current_item_price) {
             $total_discount += ($current_item_old - $current_item_price) * $qty;
             $total_price += $current_item_old * $qty;
        } else {
             $total_price += $current_item_price * $qty;
        }

        $count += $qty;
    }
    
    $final_price = $total_price - $total_discount;

    return array(
        'count' => $count,
        'total' => number_format($total_price, 2, '.', ' '),
        'discount' => number_format($total_discount, 2, '.', ' '),
        'final' => number_format($final_price, 2, '.', ' ')
    );
}

/**
 * Get Cart Count for Header
 */
function get_cart_count() {
    if (!is_user_logged_in()) return 0;
    $cart = get_user_meta(get_current_user_id(), 'cart_items', true);
    return is_array($cart) ? array_sum($cart) : 0;
}

/**
 * Register Order Custom Post Type
 */
function register_order_cpt() {
    register_post_type('order', array(
        'labels' => array(
            'name' => 'Заказы',
            'singular_name' => 'Заказ',
            'menu_name' => 'Заказы',
        ),
        'public' => false,
        'show_ui' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'supports' => array('title', 'custom-fields'),
        'menu_icon' => 'dashicons-cart',
    ));
}
add_action('init', 'register_order_cpt');

/**
 * Handle Place Order
 */
function handle_place_order() {
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Необходимо войти в систему'));
        return;
    }

    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'checkout_nonce')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }

    $user_id = get_current_user_id();
    $cart = get_user_meta($user_id, 'cart_items', true);
    
    if (empty($cart)) {
        wp_send_json_error(array('message' => 'Корзина пуста'));
        return;
    }

    // Validate fields
    $required = array('last_name', 'first_name', 'phone', 'payment_method', 'delivery_method');
    if ($_POST['delivery_method'] === 'delivery') {
        $required[] = 'street';
        $required[] = 'house';
    }

    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            wp_send_json_error(array('message' => 'Заполните все обязательные поля'));
            return;
        }
    }

    // Create Order Post
    $order_title = 'Заказ #' . uniqid(); // Temporary title, can be updated with ID later
    
    $order_data = array(
        'post_title'    => $order_title,
        'post_status'   => 'publish',
        'post_type'     => 'order',
        'post_author'   => $user_id
    );

    $order_id = wp_insert_post($order_data);

    if (is_wp_error($order_id)) {
        wp_send_json_error(array('message' => 'Ошибка при создании заказа'));
        return;
    }

    // Update Title with ID
    $final_title = 'Заказ #' . $order_id . ' от ' . date('d.m.Y H:i');
    wp_update_post(array('ID' => $order_id, 'post_title' => $final_title));

    // Save Order Meta
    $fields = array(
        'last_name', 'first_name', 'phone', 
        'delivery_method', 'street', 'house', 'entrance', 
        'payment_method', 'order_comment'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($order_id, $field, sanitize_text_field($_POST[$field]));
        }
    }

    // Save Cart Items
    $order_items = array();
    foreach ($cart as $product_id => $qty) {
        $order_items[] = array(
            'product_id' => $product_id,
            'title' => get_the_title($product_id),
            'quantity' => $qty,
            'price' => get_field('product_price', $product_id)
        );
    }
    update_post_meta($order_id, 'order_items', $order_items);
    
    // Save Totals
    $totals = calculate_cart_totals($user_id);
    update_post_meta($order_id, 'order_total', $totals['final']);

    // Clear Cart
    delete_user_meta($user_id, 'cart_items');

    wp_send_json_success(array(
        'message' => 'Заказ успешно оформлен!',
        'redirect_url' => home_url('/order-success') // Redirect to confirmation page
    ));
}
add_action('wp_ajax_place_order', 'handle_place_order');
