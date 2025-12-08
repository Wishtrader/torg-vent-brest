<?php
/**
 * Product Custom Post Type and Taxonomy Setup
 *
 * @package torg-vent-brest
 */

// Register Custom Post Type Product
function torg_vent_brest_register_product_cpt() {

	$labels = array(
		'name'                  => _x( 'Товары', 'Post Type General Name', 'torg-vent-brest' ),
		'singular_name'         => _x( 'Товар', 'Post Type Singular Name', 'torg-vent-brest' ),
		'menu_name'             => __( 'Товары', 'torg-vent-brest' ),
		'name_admin_bar'        => __( 'Товар', 'torg-vent-brest' ),
		'archives'              => __( 'Архив товаров', 'torg-vent-brest' ),
		'attributes'            => __( 'Атрибуты товара', 'torg-vent-brest' ),
		'parent_item_colon'     => __( 'Родительский товар:', 'torg-vent-brest' ),
		'all_items'             => __( 'Все товары', 'torg-vent-brest' ),
		'add_new_item'          => __( 'Добавить новый товар', 'torg-vent-brest' ),
		'add_new'               => __( 'Добавить новый', 'torg-vent-brest' ),
		'new_item'              => __( 'Новый товар', 'torg-vent-brest' ),
		'edit_item'             => __( 'Редактировать товар', 'torg-vent-brest' ),
		'update_item'           => __( 'Обновить товар', 'torg-vent-brest' ),
		'view_item'             => __( 'Просмотреть товар', 'torg-vent-brest' ),
		'view_items'            => __( 'Просмотреть товары', 'torg-vent-brest' ),
		'search_items'          => __( 'Искать товар', 'torg-vent-brest' ),
		'not_found'             => __( 'Не найдено', 'torg-vent-brest' ),
		'not_found_in_trash'    => __( 'Не найдено в корзине', 'torg-vent-brest' ),
		'featured_image'        => __( 'Изображение товара', 'torg-vent-brest' ),
		'set_featured_image'    => __( 'Установить изображение товара', 'torg-vent-brest' ),
		'remove_featured_image' => __( 'Удалить изображение товара', 'torg-vent-brest' ),
		'use_featured_image'    => __( 'Использовать как изображение товара', 'torg-vent-brest' ),
		'insert_into_item'      => __( 'Вставить в товар', 'torg-vent-brest' ),
		'uploaded_to_this_item' => __( 'Загружено для этого товара', 'torg-vent-brest' ),
		'items_list'            => __( 'Список товаров', 'torg-vent-brest' ),
		'items_list_navigation' => __( 'Навигация по списку товаров', 'torg-vent-brest' ),
		'filter_items_list'     => __( 'Фильтровать список товаров', 'torg-vent-brest' ),
	);
	$args = array(
		'label'                 => __( 'Товар', 'torg-vent-brest' ),
		'description'           => __( 'Каталог товаров', 'torg-vent-brest' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'taxonomies'            => array( 'product_cat' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-cart',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'product', $args );

}
add_action( 'init', 'torg_vent_brest_register_product_cpt', 0 );

// Register Custom Taxonomy Product Category
function torg_vent_brest_register_product_cat() {

	$labels = array(
		'name'                       => _x( 'Категории товаров', 'Taxonomy General Name', 'torg-vent-brest' ),
		'singular_name'              => _x( 'Категория товара', 'Taxonomy Singular Name', 'torg-vent-brest' ),
		'menu_name'                  => __( 'Категории', 'torg-vent-brest' ),
		'all_items'                  => __( 'Все категории', 'torg-vent-brest' ),
		'parent_item'                => __( 'Родительская категория', 'torg-vent-brest' ),
		'parent_item_colon'          => __( 'Родительская категория:', 'torg-vent-brest' ),
		'new_item_name'              => __( 'Название новой категории', 'torg-vent-brest' ),
		'add_new_item'               => __( 'Добавить новую категорию', 'torg-vent-brest' ),
		'edit_item'                  => __( 'Редактировать категорию', 'torg-vent-brest' ),
		'update_item'                => __( 'Обновить категорию', 'torg-vent-brest' ),
		'view_item'                  => __( 'Просмотреть категорию', 'torg-vent-brest' ),
		'separate_items_with_commas' => __( 'Разделяйте категории запятыми', 'torg-vent-brest' ),
		'add_or_remove_items'        => __( 'Добавить или удалить категории', 'torg-vent-brest' ),
		'choose_from_most_used'      => __( 'Выбрать из часто используемых', 'torg-vent-brest' ),
		'popular_items'              => __( 'Популярные категории', 'torg-vent-brest' ),
		'search_items'               => __( 'Искать категории', 'torg-vent-brest' ),
		'not_found'                  => __( 'Не найдено', 'torg-vent-brest' ),
		'no_terms'                   => __( 'Нет категорий', 'torg-vent-brest' ),
		'items_list'                 => __( 'Список категорий', 'torg-vent-brest' ),
		'items_list_navigation'      => __( 'Навигация по списку категорий', 'torg-vent-brest' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'product_cat', array( 'product' ), $args );

}
add_action( 'init', 'torg_vent_brest_register_product_cat', 0 );

// Register ACF Fields Programmatically
if( function_exists('acf_add_local_field_group') ):

    // Field Group for Product Category Image
    acf_add_local_field_group(array(
        'key' => 'group_product_cat_image',
        'title' => 'Изображение категории',
        'fields' => array(
            array(
                'key' => 'field_cat_image',
                'label' => 'Изображение категории',
                'name' => 'category_image',
                'type' => 'image',
                'instructions' => 'Выберите изображение для этой категории товара',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'product_cat',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

    // Field Group for Product Image (Additional/Custom)
    // Note: Products already support 'thumbnail' (Featured Image), but user asked for "select product image" via ACF specifically.
    // Adding an extra field just in case, or to be explicit.
    acf_add_local_field_group(array(
        'key' => 'group_product_image_acf',
        'title' => 'Дополнительное изображение товара (ACF)',
        'fields' => array(
            array(
                'key' => 'field_product_custom_image',
                'label' => 'Изображение товара (ACF)',
                'name' => 'product_custom_image',
                'type' => 'image',
                'instructions' => 'Выберите изображение товара (если отличается от стандартного)',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

    // Field Group for Product Basic Information
    acf_add_local_field_group(array(
        'key' => 'group_product_basic_info',
        'title' => 'Основная информация о товаре',
        'fields' => array(
            array(
                'key' => 'field_product_code',
                'label' => 'Код товара (Артикул)',
                'name' => 'product_code',
                'type' => 'text',
                'instructions' => 'Введите код или артикул товара',
                'required' => 0,
                'placeholder' => 'Например: LS-HE12KNA2AB',
            ),
            array(
                'key' => 'field_product_price',
                'label' => 'Цена товара',
                'name' => 'product_price',
                'type' => 'number',
                'instructions' => 'Введите цену товара',
                'required' => 0,
                'placeholder' => '1000.00',
                'min' => 0,
                'step' => 0.01,
            ),
            array(
                'key' => 'field_product_old_price',
                'label' => 'Старая цена',
                'name' => 'product_old_price',
                'type' => 'number',
                'instructions' => 'Введите старую цену (будет показана зачеркнутой, если товар на акции)',
                'required' => 0,
                'placeholder' => '1200.00',
                'min' => 0,
                'step' => 0.01,
            ),
            array(
                'key' => 'field_product_brand',
                'label' => 'Бренд',
                'name' => 'product_brand',
                'type' => 'text',
                'instructions' => 'Введите название бренда',
                'required' => 0,
                'placeholder' => 'Например: Lessar',
            ),
            array(
                'key' => 'field_product_model',
                'label' => 'Модель',
                'name' => 'product_model',
                'type' => 'text',
                'instructions' => 'Введите модель товара',
                'required' => 0,
                'placeholder' => 'Например: LS-HE12KNA2AB/LU-HE12KNA2AB',
            ),
            array(
                'key' => 'field_product_brand_country',
                'label' => 'Страна бренда',
                'name' => 'product_brand_country',
                'type' => 'text',
                'instructions' => 'Введите страну бренда',
                'required' => 0,
                'placeholder' => 'Например: Чехия',
            ),
            array(
                'key' => 'field_product_manufacture_country',
                'label' => 'Страна производства',
                'name' => 'product_manufacture_country',
                'type' => 'text',
                'instructions' => 'Введите страну производства',
                'required' => 0,
                'placeholder' => 'Например: Китай',
            ),
            array(
                'key' => 'field_product_measure_unit',
                'label' => 'Ед. измерения',
                'name' => 'product_measure_unit',
                'type' => 'text',
                'instructions' => 'Введите единицу измерения',
                'required' => 0,
                'placeholder' => 'Например: шт',
                'default_value' => 'шт',
            ),

            array(
                'key' => 'field_is_on_sale',
                'label' => 'Товар на акции',
                'name' => 'is_on_sale',
                'type' => 'true_false',
                'instructions' => 'Отметьте, если товар участвует в акции (будет показан бейдж "АКЦИЯ")',
                'required' => 0,
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => 'Да',
                'ui_off_text' => 'Нет',
            ),
            array(
                'key' => 'field_is_new',
                'label' => 'Товар новинка',
                'name' => 'is_new',
                'type' => 'true_false',
                'instructions' => 'Отметьте, если это новый товар (будет показан бейдж "НОВИНКА")',
                'required' => 0,
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => 'Да',
                'ui_off_text' => 'Нет',
            ),
            array(
                'key' => 'field_is_popular',
                'label' => 'Популярный товар',
                'name' => 'is_popular',
                'type' => 'true_false',
                'instructions' => 'Отметьте, если товар популярный (будет показан в разделе "Популярные товары")',
                'required' => 0,
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => 'Да',
                'ui_off_text' => 'Нет',
            ),
            array(
                'key' => 'field_product_additional_specs',
                'label' => 'Дополнительные характеристики',
                'name' => 'product_additional_specs',
                'type' => 'textarea',
                'instructions' => 'Введите характеристики с новой строки в формате "Название: Значение". Например:
Мощность: 2 кВт
Цвет: Белый',
                'required' => 0,
                'rows' => 8,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

    // Field Group for Product Specifications
    acf_add_local_field_group(array(
        'key' => 'group_product_specifications',
        'title' => 'Характеристики товара',
        'fields' => array(
            array(
                'key' => 'field_product_specs_editor',
                'label' => 'Технические характеристики (Таблица)',
                'name' => 'product_specs_editor',
                'type' => 'wysiwyg',
                'instructions' => 'Добавьте таблицу с техническими характеристиками',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

    // Field Group for Product Instructions
    acf_add_local_field_group(array(
        'key' => 'group_product_instructions',
        'title' => 'Инструкции',
        'fields' => array(
            array(
                'key' => 'field_product_instructions_editor',
                'label' => 'Инструкции',
                'name' => 'product_instructions_editor',
                'type' => 'wysiwyg',
                'instructions' => 'Добавьте инструкции (текст, ссылки на файлы)',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 3,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

    // Field Group for Product Gallery (Free Version Compatible)
    acf_add_local_field_group(array(
        'key' => 'group_product_gallery',
        'title' => 'Галерея товара',
        'fields' => array(
            array(
                'key' => 'field_product_image_1',
                'label' => 'Изображение 1',
                'name' => 'product_image_1',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_product_image_2',
                'label' => 'Изображение 2',
                'name' => 'product_image_2',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_product_image_3',
                'label' => 'Изображение 3',
                'name' => 'product_image_3',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_product_image_4',
                'label' => 'Изображение 4',
                'name' => 'product_image_4',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_product_image_5',
                'label' => 'Изображение 5',
                'name' => 'product_image_5',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 4,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;
