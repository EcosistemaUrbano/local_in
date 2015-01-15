<?php ob_start();
/*
Template Name: Login
*/
get_header();

if ( array_key_exists('ref', $_POST) && sanitize_text_field($_POST['ref']) != '' ) { $ref = sanitize_text_field($_POST['ref']); } else { $ref = WHATIF_BLOGURL; }
if ( array_key_exists('valor', $_POST) ) { $valor = sanitize_text_field($_POST['valor']); } else { $valor = ""; }

$creds = array();
if ( array_key_exists('nombre', $_POST) ) { $creds['user_login'] = sanitize_text_field($_POST['nombre']); }
if ( array_key_exists('pass', $_POST) ) { $creds['user_password'] = sanitize_text_field($_POST['pass']); }
if ( array_key_exists('remember', $_POST) ) { $creds['remember'] = sanitize_text_field($_POST['remember']); }
$user = wp_signon( $creds, false );

if ( is_wp_error($user) ) {

	$ref = WHATIF_BLOGURL. "/user-sesion";
		$ref .= "?login=error";
		wp_redirect($ref);
		exit;

} else {
	wp_redirect($ref);
	exit;
}

get_footer(); ob_end_flush(); ?>
