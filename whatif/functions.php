<?php
// theme setup main function
add_action( 'after_setup_theme', 'whatif_theme_setup' );
function whatif_theme_setup() {

	// Theme globals vars
	require_once("general-vars.php");
	if (!defined('WHATIF_BLOGURL'))
	    define('WHATIF_BLOGURL', get_option('home'));
	if (!defined('WHATIF_BLOGTHEME'))
	    define('WHATIF_BLOGTHEME', get_bloginfo('template_url'));

	if (!defined('WHATIF_SEO_BLOGNAME'))
	    define('WHATIF_SEO_BLOGNAME', $city);
	if (!defined('WHATIF_DOMAIN'))
	    define('WHATIF_DOMAIN', $wic);
	if (!defined('WHATIF_INSTALL_FOLDER'))
	    define('WHATIF_INSTALL_FOLDER', $citymin);

	if (!defined('WHATIF_LOCATION_ADDRESS'))
	    define('WHATIF_LOCATION_ADDRESS', $examplelocation);
	if (!defined('WHATIF_GOOGLE_KEY'))
	    define('WHATIF_GOOGLE_KEY', $apigooglemaps);
	if (!defined('WHATIF_MAP_COORDS'))
	    define('WHATIF_MAP_COORDS', $coordenadasmapa);
	if (!defined('WHATIF_MAP_ZOOM_FORM'))
	    define('WHATIF_MAP_ZOOM_FORM', $zoomformulario);
	if (!defined('WHATIF_MAP_ZOOM'))
	    define('WHATIF_MAP_ZOOM', $zoomtodas);
	if (!defined('WHATIF_MAP_ZOOM_SINGLE'))
	    define('WHATIF_MAP_ZOOM_SINGLE', $zoomindividual);

	if (!defined('WHATIF_STYLE_VIEW_COLOR'))
	    define('WHATIF_STYLE_VIEW_COLOR', $color_c);
	if (!defined('WHATIF_STYLE_VIEW_BG'))
	    define('WHATIF_STYLE_VIEW_BG', $bg_c);

	if (!defined('WHATIF_STYLE_FORM_COLOR'))
	    define('WHATIF_STYLE_FORM_COLOR', $color_p);
	if (!defined('WHATIF_STYLE_FORM_BG'))
	    define('WHATIF_STYLE_FORM_BG', $bg_p);

	if (!defined('WHATIF_STYLE_POSITIVE_COLOR'))
	    define('WHATIF_STYLE_POSITIVE_COLOR', $color_pl);
	if (!defined('WHATIF_STYLE_POSITIVE_BG'))
	    define('WHATIF_STYLE_POSITIVE_BG', $bg_pl);
	if (!defined('WHATIF_STYLE_POSITIVE_HOVER'))
	    define('WHATIF_STYLE_POSITIVE_HOVER', $chover_pl);

	if (!defined('WHATIF_STYLE_NEGATIVE_COLOR'))
	    define('WHATIF_STYLE_NEGATIVE_COLOR', $color_mn);
	if (!defined('WHATIF_STYLE_NEGATIVE_BG'))
	    define('WHATIF_STYLE_NEGATIVE_BG', $bg_mn);
	if (!defined('WHATIF_STYLE_NEGATIVE_HOVER'))
	    define('WHATIF_STYLE_NEGATIVE_HOVER', $chover_mn);

	// don't show admin bar
	add_filter( 'show_admin_bar', '__return_false' );

	// Create custom Taxonomies
	add_action( 'init', 'whatif_build_taxonomies', 0 );

	// Set up media options: sizes, featured images...
	add_action( 'init', 'whatif_media_options' );

	// Custom dashboard logo
	add_action('admin_head', 'whatif_custom_logo');

	// Custom menus: register theme locations
	add_action( 'init', 'whatif_register_menus' );

	// load language files
	load_theme_textdomain('whatif', get_template_directory() . '/languages');

} // END theme setup function

// Set up media options
function whatif_media_options() {
	/* Add theme support for post thumbnails (featured images). */
	add_theme_support( 'post-thumbnails', array( 'post','page') );
} // END Set up media options

// Create custom Taxonomies
function whatif_build_taxonomies() {
	register_taxonomy( 'positivo', 'post', array(
		'hierarchical' => false,
		'label' => 'Positivo',
		'query_var' => true,
		'show_admin_column' => true,
		'rewrite' => true ) );

	register_taxonomy( 'negativo', 'post', array(
		'hierarchical' => false,
		'label' => 'Negativo',
		'query_var' => true,
		'show_admin_column' => true,
		'rewrite' => true ) );
} // END create custom taxonomies

// Get the id of a page by its name
function get_page_id($page_name){
	global $wpdb;
	$page_name = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$page_name."'");
	return $page_name;
}

// Custom dashboard logo
function whatif_custom_logo() {
	echo '
	<style type="text/css">
	#header-logo { background-image: url('.get_bloginfo('template_directory').'/images/dashboard-logo.png) !important; }
	</style>
	';
}

// Custom menus: register theme locations
function whatif_register_menus() {
	if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'f-home' => 'Pie de la portada',
		  'f-vistas' => 'Pie de las vistas'
		)
	);
	}
} // END Custom menus

?>
