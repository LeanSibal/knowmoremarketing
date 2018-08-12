<?php
/**
 * Know More Marketing
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Know More Marketing
 * @author  Fort St Apps
 * @license GPL-2.0+
 * @link    https://www.fortstapps.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'knowmoremarketing_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function knowmoremarketing_localization_setup() {

	load_child_theme_textdomain( 'know-more-marketing', get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/widgets/button.php';

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Know More Marketing' );
define( 'CHILD_THEME_URL', 'https://www.fortstapps.com/' );
define( 'CHILD_THEME_VERSION', '2.6.0' );

add_action( 'wp_enqueue_scripts', 'knowmoremarketing_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function knowmoremarketing_enqueue_scripts_styles() {

	wp_enqueue_style(
		'kmm-custom',
		get_stylesheet_directory_uri() . "/css/custom.css",
		[],
		CHILD_THEME_VERSION
	);

	wp_enqueue_style(
		'genesis-fonts-monserrat',
		'//fonts.googleapis.com/css?family=Montserrat',
		array(),
		CHILD_THEME_VERSION
	);

	wp_enqueue_style(
		'genesis-fonts-monserrat',
		'//fonts.googleapis.com/css?family=Hind',
		array(),
		CHILD_THEME_VERSION
	);
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script(
		'know-more-marketing-responsive-menu',
		get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js",
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);
	wp_localize_script(
		'know-more-marketing-responsive-menu',
		'genesis_responsive_menu',
		knowmoremarketing_responsive_menu_settings()
	);

	wp_enqueue_script(
		'know-more-marketing',
		get_stylesheet_directory_uri() . '/js/know-more-marketing.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

}

/**
 * Defines responsive menu settings.
 *
 * @since 2.3.0
 */
function knowmoremarketing_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'know-more-marketing' ),
		'menuIconClass'    => 'dashicons-before dashicons-menu',
		'subMenu'          => __( 'Submenu', 'know-more-marketing' ),
		'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Sets the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 702; // Pixels.
}

// Adds support for HTML5 markup structure.
add_theme_support(
	'html5', array(
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
	)
);

// Adds support for accessibility.
add_theme_support(
	'genesis-accessibility', array(
		'404-page',
		'drop-down-menu',
		'headings',
		'rems',
		'search-form',
		'skip-links',
	)
);

// Adds viewport meta tag for mobile browsers.
add_theme_support(
	'genesis-responsive-viewport'
);

// Adds custom logo in Customizer > Site Identity.
add_theme_support(
	'custom-logo', array(
		'height'      => 120,
		'width'       => 700,
		'flex-height' => true,
		'flex-width'  => true,
	)
);

// Renames primary and secondary navigation menus.
add_theme_support(
	'genesis-menus', array(
		'primary'   => __( 'Header Menu', 'know-more-marketing' ),
		'secondary' => __( 'Footer Menu', 'know-more-marketing' ),
	)
);

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Adds support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Removes output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

add_action( 'genesis_theme_settings_metaboxes', 'knowmoremarketing_remove_metaboxes' );
/**
 * Removes output of unused admin settings metaboxes.
 *
 * @since 2.6.0
 *
 * @param string $_genesis_admin_settings The admin screen to remove meta boxes from.
 */
function knowmoremarketing_remove_metaboxes( $_genesis_admin_settings ) {

	remove_meta_box( 'genesis-theme-settings-header', $_genesis_admin_settings, 'main' );
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_admin_settings, 'main' );

}

add_filter( 'genesis_customizer_theme_settings_config', 'knowmoremarketing_remove_customizer_settings' );
/**
 * Removes output of header settings in the Customizer.
 *
 * @since 2.6.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function knowmoremarketing_remove_customizer_settings( $config ) {

	unset( $config['genesis']['sections']['genesis_header'] );
	return $config;

}

// Displays custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'knowmoremarketing_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function knowmoremarketing_secondary_menu_args( $args ) {

	if ( 'secondary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'knowmoremarketing_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function knowmoremarketing_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'knowmoremarketing_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function knowmoremarketing_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );


add_filter( 'genesis_attr_gradient-button', 'knowmoremarketing_attributes_gradient_button' );
function knowmoremarketing_attributes_gradient_button( $attributes ) {
	$attributes['class'] = 'btn gradient';
	return $attributes;
}

add_action( 'genesis_header', 'knowmoremarketing_right_menu_open', 13);
function knowmoremarketing_right_menu_open(){
	genesis_markup([
		'open' => '<nav %s>',
		'context' => 'right-menu'
	]);
	genesis_structural_wrap( 'nav' );
	genesis_markup([
		'open' => sprintf( '<button %s>', genesis_attr( 'gradient-button' ) ),
		'content' => 'Hello',
		'close' => '</button>'
	]);
	genesis_structural_wrap( 'nav', 'close' );
	genesis_markup([
		'close' => '</nav>',
		'context' => 'right-menu'
	]);
}

