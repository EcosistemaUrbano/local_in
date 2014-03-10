<?php ob_start();
/*
Template Name: Registro de usuario
*/
get_header();

include "general-vars.php";

	$nombre = $_POST['nombre'];
	$mail = $_POST['mail'];
	$pass = $_POST['pass'];
	$pass2 = $_POST['pass2'];
	$ref = $_POST['ref'];

	require_once(ABSPATH . WPINC . '/registration.php');
	$user_id = username_exists( $nombre ); // nos aseguramos que el user no existe

if ( $user_id ) {
	$ref .= "?fail=name";
//	require (ABSPATH . WPINC . '/pluggable.php');
//add_action( 'init', 'redireccion', 0 );
//function redireccion(){
	wp_redirect($ref);
	exit;
//}
//$reg_out = "
//	El nombre de usuario que has elegido ya existe. Prueba con otro.
//	<form action='$home/login.php' method='post'>
//		<strong>Nombre:</strong>
//		<input type='text' name='nombre' value='' />
//		Correo:
//		<input type='text' name='mail' value='' />
//		Contraseña:
//		<input type='text' name='pass' value='' />
//		Confirmación de la contraseña:
//		<input type='text' name='pass2' value='' />
//	</form>
//
//";

} elseif ( email_exists($mail) ) {
	$ref .= "?fail=mail&noheader=true";
	wp_redirect($ref);
	exit;

//$reg_out = "
//	El correo que has elegido ya está asociado a otro usuario. Tendrás que elegir otro.
//	<form action='$home/login.php' method='post'>
//		Nombre:
//		<input type='text' name='nombre' value='' />
//		<strong>Correo:</strong>
//		<input type='text' name='mail' value='' />
//		Contraseña:
//		<input type='text' name='pass' value='' />
//		Confirmación de la contraseña:
//		<input type='text' name='pass2' value='' />
//	</form>
//
//";

} elseif ( $pass != $pass2 ) {
	$ref .= "?fail=pass&noheader=true";
	wp_redirect($ref);
	exit;

//$reg_out = "
//	Revisa tu contraseña
//	<form action='$home/login.php' method='post'>
//		Nombre:
//		<input type='text' name='nombre' value='' />
//		Correo:
//		<input type='text' name='mail' value='' />
//		<strong>Contraseña:</strong>
//		<input type='text' name='pass' value='' />
//		</strong>Confirmación de la contraseña:</strong>
//		<input type='text' name='pass2' value='' />
//	</form>
//
//";

} else {
//	if (isset($_GET['noheader'])) {
//            get_header();
//	}
	$random_pass = wp_generate_password( 12, false ); // esto se puede usar para que no sea necesario incluir passw
	if ( $pass == '' ) { $pass = $random_pass; }
//	$datos = array(
//		"user_login"=>$_POST['nombre'], // Nombre de usuario para login
//		"user_pass"=>$pass, // Contraseña
//		//"user_url"=>$_POST['url'], // Website del usuario
//		"user_email"=>$_POST['mail'], // E-mail
//		"display_name"=>$_POST['nombre'], // Nombre a mostrar del usuario en comentarios y mensajes
//		//"first_name "=>$_POST['nombre'], // Nombre del usuario
//		//"last_name"=>$_POST['apellidos'], // Apellidos
//		"role"=>"author"
//	);
		$user_id = wp_create_user( $nombre, $pass, $mail );

$reg_out = __('Tu usuario ha sido creado correctamente.','whatif');
$reg_out .= "$user_id";
}

echo $reg_out;

get_footer(); ob_end_flush(); ?>
