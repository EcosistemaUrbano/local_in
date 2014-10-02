<?php ob_start();
/*
Template Name: Registro de usuario
*/
get_header();

if ( array_key_exists('nombre', $_POST) ) { $nombre = sanitize_text_field($_POST['nombre']); }
if ( array_key_exists('mail', $_POST) ) { $mail = sanitize_text_field($_POST['mail']); }
if ( array_key_exists('pass', $_POST) ) { $pass = sanitize_text_field($_POST['pass']); }
if ( array_key_exists('pass2', $_POST) ) { $pass2 = sanitize_text_field($_POST['pass2']); }
if ( array_key_exists('ref', $_POST) ) { $ref = sanitize_text_field($_POST['ref']); } else { $ref = WHATIF_BLOGURL; }

$user_id = username_exists( $nombre ); // nos aseguramos que el user no existe

if ( $user_id ) {
	$redirect = WHATIF_BLOGURL. "/user-sesion?fail=name&ref=" .$ref;
	wp_redirect($redirect);
	exit;

} elseif ( email_exists($mail) ) {
	$redirect = WHATIF_BLOGURL. "/user-sesion?fail=mail&ref=" .$ref;
	wp_redirect($redirect);
	exit;

} elseif ( $pass != $pass2 ) {
	$redirect = WHATIF_BLOGURL. "/user-sesion?fail=pass&ref=" .$ref;
	wp_redirect($redirect);
	exit;

} else {

	$random_pass = wp_generate_password( 12, false ); // esto se puede usar para que no sea necesario incluir passw
	if ( $pass == '' ) { $pass = $random_pass; }
	$user_id = wp_create_user( $nombre, $pass, $mail );

	$redirect = WHATIF_BLOGURL. "/user-sesion?signup=success&ref=" .$ref;
	wp_redirect($redirect);
	exit;

$reg_out = __('Tu usuario ha sido creado correctamente.','whatif');
}

echo $reg_out;

get_footer(); ob_end_flush(); ?>
