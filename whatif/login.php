<?php ob_start();
/*
Template Name: Login
*/
get_header();

include "general-vars.php";

	$ref = $_POST['ref'];
	$valor = $_POST['valor'];

$creds = array();
$creds['user_login'] = $_POST['nombre'];
$creds['user_password'] = $_POST['pass'];
$creds['remember'] = $_POST['remember'];
$user = wp_signon( $creds, false );

if ( is_wp_error($user) ) {

   if ($valor !="")
   {
//	$error_string = $user->get_error_message();
	$ref .= "?login=error&valor=$valor";
	wp_redirect($ref);
	exit;
	}
	if ($valor=="")
	{
	$ref = "http://whatifcities.com/".$citymin."/formulario/?valor=positivo";
	wp_redirect($ref);
	exit;	
	
	}
} else {
	$ref .= "?valor=$valor";
	wp_redirect($ref);
	exit;
}
//   echo $user->get_error_message();


	//require_once(ABSPATH . WPINC . '/registration.php');
	//$user_id = username_exists( $nombre ); // nos aseguramos que el user no existe

//if ( $user_id ) {
//	$ref .= "?fail=name";
//	wp_redirect($ref);
//	exit;
//
//} elseif ( email_exists($mail) ) {
//	$ref .= "?fail=mail";
//	wp_redirect($ref);
//	exit;
//
//} elseif ( $pass != $pass2 ) {
//	$ref .= "?fail=pass";
//	wp_redirect($ref);
//	exit;
//
//} else {
//	$random_pass = wp_generate_password( 12, false ); // esto se puede usar para que no sea necesario incluir passw
//	if ( $pass == '' ) { $pass = $random_pass; }
////	$datos = array(
////		"user_login"=>$_POST['nombre'], // Nombre de usuario para login
////		"user_pass"=>$pass, // Contraseña
////		//"user_url"=>$_POST['url'], // Website del usuario
////		"user_email"=>$_POST['mail'], // E-mail
////		"display_name"=>$_POST['nombre'], // Nombre a mostrar del usuario en comentarios y mensajes
////		//"first_name "=>$_POST['nombre'], // Nombre del usuario
////		//"last_name"=>$_POST['apellidos'], // Apellidos
////		"role"=>"author"
////	);
//		$user_id = wp_create_user( $nombre, $pass, $mail );
//
//$reg_out = "Tu usuario ha sido creado correctamente.";
//$reg_out .= "$user_id";
//}
//
//echo $reg_out;

get_footer(); ob_end_flush(); ?>
