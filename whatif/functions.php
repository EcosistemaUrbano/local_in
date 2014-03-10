<?php
add_filter( 'show_admin_bar', '__return_false' );

add_theme_support( 'post-thumbnails' );

// Get the id of a page by its name
function get_page_id($page_name){
	global $wpdb;
	$page_name = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$page_name."'");
	return $page_name;
}

// Custom Taxonomy Code
add_action( 'init', 'build_taxonomies', 0 );

function build_taxonomies() {
	register_taxonomy( 'positivo', 'post', array(
		'hierarchical' => false,
		'label' => 'Positivo',
		'query_var' => true,
		'rewrite' => true ) );

	register_taxonomy( 'negativo', 'post', array(
		'hierarchical' => false,
		'label' => 'Negativo',
		'query_var' => true,
		'rewrite' => true ) );
}

// CUSTOM DASHBOARD LOGO
//hook the administrative header output
add_action('admin_head', 'my_custom_logo');

function my_custom_logo() {
	echo '
	<style type="text/css">
	#header-logo { background-image: url('.get_bloginfo('template_directory').'/images/dashboard-logo.png) !important; }
	</style>
	';
}

// CUSTOM MENUS: register theme locations
add_action( 'init', 'register_my_menu' );
function register_my_menu() {
	if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'f-home' => 'Pie de la portada',
		  'f-vistas' => 'Pie de las vistas'
		)
	);
	}
}

// hook to say WordPress that language files are in /languages directory, inside the theme one
add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup(){
	load_theme_textdomain('whatif', get_template_directory() . '/languages');
}

?>
