<?php
/**
 * ExtraMile Theme 2023 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ExtraMile_Theme_2023
 */

if ( ! defined( 'EXTRAMILE_THEME_2023_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'EXTRAMILE_THEME_2023_VERSION', '0.1.0' );
	define( 'EXTRAMILE_THEME_SLUG', 'extramile-theme-2023' );
	define( 'EXTRAMILE_BLOCK_CATEGORY', 'extra-mile-communications' );
}

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/functions/helper-functions.php';
require get_template_directory() . '/inc/functions/template-functions.php';
require get_template_directory() . '/inc/functions/ajax-functions.php';
require get_template_directory() . '/inc/functions/nav-functions.php';

if(is_acf_activated()) {
	require get_template_directory() . '/inc/functions/acf-functions.php';
}

if(is_woocommerce_activated()) {
	require get_template_directory() . '/inc/functions/woocommerce-functions.php';
}

if ( ! function_exists( 'extramile_theme_2023_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function extramile_theme_2023_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ExtraMile Theme 2023, use a find and replace
		 * to change 'extramile-theme-2023' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'extramile-theme-2023', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'main-menu' => __( 'Site Nav', 'extramile-theme-2023' ),
				'mobile' => __( 'Mobile Menu', 'extramile-theme-2023' ),
				'footer-menu' => __( 'Footer Menu', 'extramile-theme-2023' ),
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
				// 'comment-form',
				// 'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		if(is_woocommerce_activated()) {
			add_theme_support( 'woocommerce' );
		}

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		// remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'extramile_theme_2023_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function extramile_theme_2023_widgets_init() {
	register_sidebar(array(
        'name' => __('Footer Widget Area 1', 'extramile'),
        'id' => 'footer-widget-area-1',
        'description' => __('The first footer widget area', 'extramile'),
        'before_widget' => '<div class="widget-area">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
	
    register_sidebar(array(
        'name' => __('Footer Widget Area 2', 'extramile'),
        'id' => 'footer-widget-area-2',
        'description' => __('The second footer widget area', 'extramile'),
        'before_widget' => '<div class="widget-area">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget Area 3', 'extramile'),
        'id' => 'footer-widget-area-3',
        'description' => __('The third footer widget area', 'extramile'),
        'before_widget' => '<div class="widget-area">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action( 'widgets_init', 'extramile_theme_2023_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function extramile_theme_2023_scripts() {
	wp_enqueue_style( 'extramile-theme-2023-style', get_stylesheet_uri(), array(), EXTRAMILE_THEME_2023_VERSION );
	wp_register_script( 'extramile-theme-2023-script', get_template_directory_uri() . '/js/script.min.js', array('jquery'), EXTRAMILE_THEME_2023_VERSION, true );
	wp_localize_script( 'extramile-theme-2023-script', 'emc_loadmore', array('ajaxurl' => admin_url('admin-ajax.php'),'nonce' => wp_create_nonce( 'emc-nonce' )));
	wp_enqueue_script( 'extramile-theme-2023-script' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	//enqueue Slick slider
	wp_enqueue_style('extramile-template-2023-slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css', array(), '1.9.0');
	wp_enqueue_style('extramile-template-2023-slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css', array(), '1.9.0');
	wp_enqueue_script('slick-slidr', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', array(), '1.9.0', true);

	//add font awesome 5
	wp_enqueue_style('extramile-template-2022-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css', array(), '6.3.1');
}
add_action( 'wp_enqueue_scripts', 'extramile_theme_2023_scripts' );

/**
 * Add the block editor class to TinyMCE.
 *
 * This allows TinyMCE to use Tailwind Typography styles.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function extramile_theme_2023_tinymce_add_class( $settings ) {
	$settings['body_class'] = 'block-editor-block-list__layout';
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'extramile_theme_2023_tinymce_add_class' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
