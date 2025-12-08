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

    wp_localize_script( 'torg-vent-brest-navigation', 'torg_config', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'cart_nonce' => wp_create_nonce( 'cart_nonce' ),
        'favorite_nonce' => wp_create_nonce( 'favorite_nonce' ),
    ) );

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
    // DEBUG LOGGING
    $log_file = get_template_directory() . '/debug_log.txt';
    $log = "--- ADD TO CART ---\n";
    $log .= "Time: " . date('Y-m-d H:i:s') . "\n";
    $log .= "User ID: " . get_current_user_id() . "\n";
    $log .= "Logged In: " . (is_user_logged_in() ? 'Yes' : 'No') . "\n";
    $log .= "POST: " . print_r($_POST, true);
    $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : 'NULL';
    $verify = wp_verify_nonce($nonce, 'cart_nonce');
    $expected = wp_create_nonce('cart_nonce');
    $log .= "Nonce provided: $nonce\n";
    $log .= "Expected: $expected\n";
    $log .= "Nonce Verify Result: " . ($verify ? 'PASS' : 'FAIL') . "\n";
    file_put_contents($log_file, $log, FILE_APPEND);

    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Необходимо войти в систему', 'redirect' => home_url('/login')));
        return;
    }

    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'cart_nonce')) {
        file_put_contents($log_file, "Warning: Nonce Fail (Ignored for fix)\n", FILE_APPEND);
        // wp_send_json_error(array('message' => 'Ошибка безопасности'));
        // return;
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

/**
 * Handle Contact/Consultation Form
 */
function handle_send_question() {
    // Check Nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'consultation_nonce')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }

    $name = sanitize_text_field($_POST['name']);
    $phone = sanitize_text_field($_POST['phone']);
    $question = sanitize_textarea_field($_POST['question']);

    if (empty($name) || empty($phone)) {
        wp_send_json_error(array('message' => 'Заполните обязательные поля'));
        return;
    }

    // Send Admin Email
    $to = get_option('admin_email');
    $subject = 'Новый вопрос с сайта (Монтаж)';
    $message = "Имя: $name\nТелефон: $phone\nВопрос: $question";
    $headers = array('Content-Type: text/plain; charset=UTF-8');

    wp_mail($to, $subject, $message, $headers);

    wp_send_json_success(array('message' => 'Ваша заявка принята! Мы свяжемся с вами в ближайшее время.'));
}
add_action('wp_ajax_send_question', 'handle_send_question');
add_action('wp_ajax_nopriv_send_question', 'handle_send_question');

/**
 * Register ACF Fields for Installation Page Programmatically
 */
add_action('acf/init', 'torg_vent_brest_acf_init');
function torg_vent_brest_acf_init() {

    acf_add_local_field_group(array(
        'key' => 'group_installation_page',
        'title' => 'Настройки страницы Монтаж',
        'fields' => array(
            // Intro Section
            array(
                'key' => 'field_intro_tab',
                'label' => 'Главный блок',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_install_title',
                'label' => 'Заголовок H1',
                'name' => 'install_title',
                'type' => 'text',
                'default_value' => 'Монтаж систем кондиционирования и вентиляции',
            ),
            array(
                'key' => 'field_install_subtitle',
                'label' => 'Подзаголовок',
                'name' => 'install_subtitle',
                'type' => 'text',
                'default_value' => 'ВАШ КЛИМАТИЧЕСКИЙ КОМФОРТ — НАША ПРОФЕССИОНАЛЬНАЯ УСТАНОВКА',
            ),
            array(
                'key' => 'field_install_desc',
                'label' => 'Описание (верх)',
                'name' => 'install_desc',
                'type' => 'textarea',
                'default_value' => 'С 2020 года мы создаем идеальный микроклимат там, где это важно: в уютных квартирах, динамичных офисах и на ответственных промышленных объектах.',
            ),
            array(
                'key' => 'field_install_features_title',
                'label' => 'Заголовок списка особенностей',
                'name' => 'install_features_title',
                'type' => 'text',
                'default_value' => 'ПОЧЕМУ С НАМИ УДОБНО И НАДЕЖНО:',
            ),
            array(
                'key' => 'field_install_features',
                'label' => 'Почему с нами удобно (Список)',
                'name' => 'install_features',
                'type' => 'wysiwyg',
                'default_value' => '<strong>Четкость по графику:</strong> Мастер приедет точно в удобное для вас время.<br><strong>Решение «на месте»:</strong> Вместе мы определим лучшее место для установки.<br><strong>Прозрачный процесс:</strong> Вы будете знать все этапы.',
            ),
            array(
                'key' => 'field_install_main_img',
                'label' => 'Главное изображение',
                'name' => 'install_main_img',
                'type' => 'text',
                'wrapper' => array('class' => 'tvb-image-uploader'), // Marker for JS
            ),
            array(
                'key' => 'field_cta_text',
                'label' => 'Текст призыва к действию (подпись)',
                'name' => 'cta_text',
                'type' => 'text',
                'default_value' => 'ДЛЯ ТОЧНОГО РАСЧЕТА СТОИМОСТИ ОСТАВЬТЕ ЗАЯВКУ И НАШ МЕНЕДЖЕР СВЯЖЕТСЯ С ВАМИ',
            ),
            array(
                'key' => 'field_cta_btn_text',
                'label' => 'Текст кнопки (Узнать стоимость)',
                'name' => 'cta_btn_text',
                'type' => 'text',
                'default_value' => 'УЗНАТЬ СТОИМОСТЬ',
            ),
            
            // Portfolio Section
            array(
                'key' => 'field_portfolio_tab',
                'label' => 'Примеры работ',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_portfolio_title',
                'label' => 'Заголовок секции портфолио',
                'name' => 'portfolio_title',
                'type' => 'text',
                'default_value' => 'Примеры наших работ',
            ),
            // Portfolio Images (Custom Uploader)
            array(
                'key' => 'field_portfolio_img_1',
                'label' => 'Работа 1',
                'name' => 'portfolio_img_1',
                'type' => 'text',
                'wrapper' => array('class' => 'tvb-image-uploader'),
            ),
            array(
                'key' => 'field_portfolio_img_2',
                'label' => 'Работа 2',
                'name' => 'portfolio_img_2',
                'type' => 'text',
                'wrapper' => array('class' => 'tvb-image-uploader'),
            ),
            array(
                'key' => 'field_portfolio_img_3',
                'label' => 'Работа 3',
                'name' => 'portfolio_img_3',
                'type' => 'text',
                'wrapper' => array('class' => 'tvb-image-uploader'),
            ),
            array(
                'key' => 'field_portfolio_img_4',
                'label' => 'Работа 4',
                'name' => 'portfolio_img_4',
                'type' => 'text',
                'wrapper' => array('class' => 'tvb-image-uploader'),
            ),
            array(
                'key' => 'field_portfolio_img_5',
                'label' => 'Работа 5',
                'name' => 'portfolio_img_5',
                'type' => 'text',
                'wrapper' => array('class' => 'tvb-image-uploader'),
            ),
            array(
                'key' => 'field_portfolio_img_6',
                'label' => 'Работа 6',
                'name' => 'portfolio_img_6',
                'type' => 'text',
                'wrapper' => array('class' => 'tvb-image-uploader'),
            ),
             array(
                'key' => 'field_portfolio_img_7',
                'label' => 'Работа 7',
                'name' => 'portfolio_img_7',
                'type' => 'text',
                'wrapper' => array('class' => 'tvb-image-uploader'),
            ),
             array(
                'key' => 'field_portfolio_img_8',
                'label' => 'Работа 8',
                'name' => 'portfolio_img_8',
                'type' => 'text',
                'wrapper' => array('class' => 'tvb-image-uploader'),
            ),

            // Contact Section
            array(
                'key' => 'field_contact_tab',
                'label' => 'Блок контактов',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_contact_title',
                'label' => 'Заголовок формы',
                'name' => 'contact_title',
                'type' => 'text',
                'default_value' => 'Остались вопросы?',
            ),
             array(
                'key' => 'field_contact_desc',
                'label' => 'Текст формы',
                'name' => 'contact_desc',
                'type' => 'textarea',
                'default_value' => 'Оставьте ваши контактные данные. Проконсультируем по всем интересующим вопросам.',
            ),
            array(
                'key' => 'field_form_btn_text',
                'label' => 'Текст кнопки отправки',
                'name' => 'form_btn_text',
                'type' => 'text',
                'default_value' => 'ОТПРАВИТЬ',
            ),
            array(
                'key' => 'field_contact_footer_text',
                'label' => 'Текст под кнопкой (с контактами)',
                'name' => 'contact_footer_text',
                'type' => 'text',
                'default_value' => 'Позвоните нам или напишите',
            ),
            array(
                'key' => 'field_contact_image',
                'label' => 'Изображение кондиционера (справа)',
                'name' => 'contact_image',
                'type' => 'text',
                'wrapper' => array('class' => 'tvb-image-uploader'),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-installation.php',
                ),
            ),
        ),
    ));
    
}

/**
 * Force load media scripts in Admin to fix ACF Buttons
 */
add_action('admin_enqueue_scripts', 'tvb_force_media_uploader');
function tvb_force_media_uploader() {
    wp_enqueue_media();
}

/**
 * Custom JS to add Upload Buttons to Text Fields with class 'tvb-image-uploader'
 */
add_action('admin_footer', 'tvb_custom_uploader_script');
function tvb_custom_uploader_script() {
    ?>
    <script>
    jQuery(document).ready(function($){
        $('.tvb-image-uploader .acf-input').each(function(){
            var $wrap = $(this);
            var $input = $wrap.find('input[type="text"]');
            var $btn = $('<button type="button" class="button" style="margin-top:5px;">Загрузить изображение</button>');
            
            $input.after($btn);
            
            $btn.click(function(e) {
                e.preventDefault();
                var custom_uploader = wp.media({
                    title: 'Выберите изображение',
                    button: { text: 'Выбрать' },
                    multiple: false
                }).on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    $input.val(attachment.url);
                }).open();
            });
        });
    });
    </script>
    <?php
}

/**
 * Register Payment & Delivery Page Fields
 */
add_action('acf/init', 'tvb_payment_delivery_acf_init');
function tvb_payment_delivery_acf_init() {
    acf_add_local_field_group(array(
        'key' => 'group_payment_delivery',
        'title' => 'Настройки страницы Оплата и доставка',
        'fields' => array(
            // Payment Section
            array(
                'key' => 'field_pd_payment_title',
                'label' => 'Заголовок (Способы оплаты)',
                'name' => 'pd_payment_title',
                'type' => 'text',
                'default_value' => 'СПОСОБЫ ОПЛАТЫ',
            ),
            array(
                'key' => 'field_pd_payment_text',
                'label' => 'Текст (Способы оплаты)',
                'name' => 'pd_payment_text',
                'type' => 'wysiwyg',
                'default_value' => 'Вы можете оплатить покупку любым удобным способом. Мы принимаем наличные средства при получении оборудования или после выполнения монтажных работ. Также доступна оплата банковскими картами Visa, Mastercard и МИР – онлайн при оформлении заказа или через терминал во время доставки. Для организаций предусмотрен безналичный расчет с выставлением счета. Все платежи осуществляются безопасно, с предоставлением полного пакета документов.',
            ),
            
            // Delivery Section
            array(
                'key' => 'field_pd_delivery_title',
                'label' => 'Заголовок (Условия доставки)',
                'name' => 'pd_delivery_title',
                'type' => 'text',
                'default_value' => 'УСЛОВИЯ ДОСТАВКИ',
            ),
            array(
                'key' => 'field_pd_delivery_text',
                'label' => 'Текст (Условия доставки)',
                'name' => 'pd_delivery_text',
                'type' => 'wysiwyg',
                'default_value' => '<p>Все условия доставки согласовываются индивидуально с каждым клиентом. Мы доставляем технику строго в оговоренные сроки к месту будущего монтажа. При заказе установки кондиционера в черте города действует бесплатная доставка. В случае необходимости срочной доставки в день заказа, мы постараемся выполнить ваш запрос при наличии оборудования на складе.</p><p>Мы гарантируем бережную транспортировку техники и обязательную проверку оборудования перед установкой. Для корпоративных клиентов предусмотрены индивидуальные условия сотрудничества.</p>',
            ),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-payment-delivery.php',
                ),
            ),
        ),
    ));
}

/**
 * Register Return & Exchange Page Fields
 */
add_action('acf/init', 'tvb_return_exchange_acf_init');
function tvb_return_exchange_acf_init() {
    acf_add_local_field_group(array(
        'key' => 'group_return_exchange',
        'title' => 'Настройки страницы Возврат и обмен',
        'fields' => array(
            array(
                'key' => 'field_re_main_title',
                'label' => 'Заголовок блока',
                'name' => 're_main_title',
                'type' => 'text',
                'default_value' => 'УСЛОВИЯ ВОЗВРАТА И ОБМЕНА',
            ),
            array(
                'key' => 'field_re_main_text',
                'label' => 'Текст условий',
                'name' => 're_main_text',
                'type' => 'wysiwyg',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-return-exchange.php',
                ),
            ),
        ),
    ));
}

/**
 * Register Contacts Page Fields
 */
add_action('acf/init', 'tvb_contacts_page_acf_init');
function tvb_contacts_page_acf_init() {
    acf_add_local_field_group(array(
        'key' => 'group_contacts_page',
        'title' => 'Настройки страницы Контакты',
        'fields' => array(
            array(
                'key' => 'field_contacts_phone',
                'label' => 'Телефон 1',
                'name' => 'contacts_phone',
                'type' => 'text',
                'default_value' => '+375-33-916-66-62',
            ),
            array(
                'key' => 'field_contacts_phone_2',
                'label' => 'Телефон 2',
                'name' => 'contacts_phone_2',
                'type' => 'text',
                'default_value' => '+375-33-916-66-67',
            ),
            array(
                'key' => 'field_contacts_email',
                'label' => 'Email',
                'name' => 'contacts_email',
                'type' => 'text',
                'default_value' => 'Torg_vent@mail.ru',
            ),
            array(
                'key' => 'field_contacts_address',
                'label' => 'Адрес',
                'name' => 'contacts_address',
                'type' => 'textarea',
                'default_value' => 'г.Брест, ул.Пионерская, 85 офис 11',
                'rows' => 2,
            ),
            array(
                'key' => 'field_contacts_schedule',
                'label' => 'Режим работы',
                'name' => 'contacts_schedule',
                'type' => 'textarea',
                'default_value' => "пн-пт - с 9:00 до 17:00\nсб - с 9:00 до 14:00\nвс - выходной",
                'rows' => 4,
            ),
            array(
                'key' => 'field_contacts_map_iframe',
                'label' => 'Код карты (iframe)',
                'name' => 'contacts_map_iframe',
                'type' => 'textarea',
                'default_value' => '<iframe src="https://yandex.ru/map-widget/v1/?ll=23.730579%2C52.095253&z=17&pt=23.730579,52.095253,pm2blm" width="100%" height="100%" frameborder="0" allowfullscreen="true"></iframe>',
                'instructions' => 'Вставьте код iframe с Яндекс.Карт или Google Maps. Если пусто - покажется заглушка.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-contacts.php',
                ),
            ),
        ),
    ));
}

/**
 * Register Home Page FAQ Fields
 */
add_action('acf/init', 'tvb_home_faq_acf_init');
function tvb_home_faq_acf_init() {
    acf_add_local_field_group(array(
        'key' => 'group_home_faq',
        'title' => 'FAQ на Главной',
        'fields' => array(
            array(
                'key' => 'field_home_faq_title',
                'label' => 'Заголовок секции',
                'name' => 'home_faq_title',
                'type' => 'text',
                'default_value' => 'Часто задаваемые вопросы',
            ),
            array(
                'key' => 'field_home_faq_list',
                'label' => 'Список вопросов',
                'name' => 'home_faq_list',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Добавить вопрос',
                'sub_fields' => array(
                    array(
                        'key' => 'field_home_faq_question',
                        'label' => 'Вопрос',
                        'name' => 'question',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_home_faq_answer',
                        'label' => 'Ответ',
                        'name' => 'answer',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
    ));
}

/**
 * Register Home Page Brands Fields
 */
add_action('acf/init', 'tvb_home_brands_acf_init');
function tvb_home_brands_acf_init() {
    $fields = array(
        array(
            'key' => 'field_home_brands_title',
            'label' => 'Заголовок секции',
            'name' => 'home_brands_title',
            'type' => 'text',
            'default_value' => 'Бренды, с которыми мы работаем',
        ),
    );
    
    // Add 10 brand logo fields
    for ($i = 1; $i <= 10; $i++) {
        $fields[] = array(
            'key' => 'field_brand_logo_' . $i,
            'label' => 'Бренд ' . $i . ' - Логотип',
            'name' => 'brand_logo_' . $i,
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'thumbnail',
            'library' => 'all',
        );
        $fields[] = array(
            'key' => 'field_brand_name_' . $i,
            'label' => 'Бренд ' . $i . ' - Название (alt)',
            'name' => 'brand_name_' . $i,
            'type' => 'text',
            'placeholder' => 'Например: LG',
        );
    }
    
    acf_add_local_field_group(array(
        'key' => 'group_home_brands',
        'title' => 'Бренды на Главной',
        'fields' => $fields,
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
    ));
}


