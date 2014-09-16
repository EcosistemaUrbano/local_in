<?php
/*
Template Name: Formulario de login y registro
*/

get_header();

	$tags_tit = get_the_title();
	$bg = "bgB";
	$color = "colorB";
	$tit_out = "
	<div class='tit-peq'>
		<h2>$tags_tit</h2>
	</div>
	";
	echo $tit_out;
?>
	<div class="unique">
		<div class="unique-text <?php echo $bg ?>">
		<p><?php _e('Iniciar sesión','whatif'); ?></p>

	<?php // login form
	if ( array_key_exists('fail', $_GET) ) { $fail = sanitize_text_field($_GET['fail']); } else { $fail = ""; }
	if ( array_key_exists('login', $_GET) ) { $logerror = sanitize_text_field($_GET['login']); } else { $logerror = ""; }
	if ( array_key_exists('ref', $_GET) ) { $perma = sanitize_text_field($_GET['ref']); } else { $perma = ""; }
	$login_out ="
	<div class='user-form' id='login-form'>
	<form action='".WHATIF_BLOGURL."/login' method='post'>
	";
	if ( $logerror != '' ) :
	$login_out .= "
		<input class='login-caja error' type='text' name='nombre' value='" . __('usuario o contraseña incorrectos','whatif') . "' onblur=\"if(this.value == '') {this.value = '" . __('usuario o contraseña incorrectos','whatif') . "';}\" onfocus=\"if(this.value == '" . __('usuario o contraseña incorrectos','whatif') . "') {this.value = '';}\" />
	";
	else :
	$login_out .= "
		<input class='login-caja ".$color."' type='text' name='nombre' value='" . __('usuario','whatif') . "' onblur=\"if(this.value == '') {this.value = '" . __('usuario','whatif') . "';}\" onfocus=\"if(this.value == '" . __('usuario','whatif') . "') {this.value = '';}\" />
	";
	endif;
	$login_out .= "
		<input class='login-caja ".$color."' type='password' name='pass' value='" . __('contraseña','whatif') . "' onblur=\"if(this.value == '') {this.value = '" . __('contraseña','whatif') . "';}\" onfocus=\"if(this.value == '" . __('contraseña','whatif') . "') {this.value = '';}\" />
		<input type='hidden' name='ref' value='".$perma."' />
		<input class='login-boton ".$color."' type='submit' value='" . __('Iniciar sesión','whatif') . "' name='login' />
		<fieldset class='login-check'><label>" . __('Recordarme','whatif') . "</label>
			<input type='checkbox' name='remember' value='true' />
		</fieldset>

	</form>
	</div>
	";

	$reg_out ="
	<div class='user-form' id='reg-form'>
		<h3>" . __('Si aún no estás registrado:','whatif') . "</h3>
	<form action='".WHATIF_BLOGURL."/registro' method='post'>
	";
	if ( $fail == 'name' ) { $reg_out .="<input class='login-caja error' type='text' name='nombre' value='" . __('el nombre ya existe','whatif') . "' onblur=\"if(this.value == '') {this.value = '" . __('el nombre ya existe','whatif') . "';}\" onfocus=\"if(this.value == '" . __('el nombre ya existe','whatif') . "') {this.value = '';}\" />"; }
	else { $reg_out .="<input class='login-caja ".$color."' type='text' name='nombre' value='nombre de usuario' onblur=\"if(this.value == '') {this.value = 'nombre de usuario';}\" onfocus=\"if(this.value == 'nombre de usuario') {this.value = '';}\" />"; }
	$reg_out .= "<span>" . __('sin espacios','whatif') . "</span>";

	if ( $fail == 'mail' ) { $reg_out .="<input class='login-caja error' type='text' name='mail' value='" . __('correo asociado a otro usuario','whatif') . "' onblur=\"if(this.value == '') {this.value = '" . __('correo asociado a otro usuario','whatif') . "';}\" onfocus=\"if(this.value == '" . __('correo asociado a otro usuario','whatif') . "') {this.value = '';}\" />"; }
	else { $reg_out .= "<input class='login-caja ".$color."' type='text' name='mail' value='" . __('correo electrónico','whatif') . "' onblur=\"if(this.value == '') {this.value = '" . __('correo electrónico','whatif') . "';}\" onfocus=\"if(this.value == '" . __('correo electrónico','whatif') . "') {this.value = '';}\" />"; }

	$reg_out .= "
		<input class='login-caja ".$color."' type='password' name='pass' value='' />
		<span>" . __('contraseña','whatif') . "</span>
		<input class='login-caja ".$color."' type='password' name='pass2' value='' />
	";
	if ( $fail == 'pass' ) { $reg_out .= "<span class='error'>" . __('parece que te has equivocado al teclear...','whatif') . "</span>"; }
	else { $reg_out .= "<span>" . __('confirma tu contraseña','whatif') . "</span>"; }

	$reg_out .=  "
		<input type='hidden' name='ref' value='".$perma."' />
		<input class='login-boton ".$color."' type='submit' value='" . __('Registrarse','whatif') . "' name='registro' />
	</form>
	</div>
	";
	echo $login_out;
	echo $reg_out;

		?>

		</div>
	</div>

<?php get_footer(); ?>
