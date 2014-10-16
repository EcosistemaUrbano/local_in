<?php
/*
Template Name: Formulario de login y registro
*/

get_header();

$tags_tit = get_the_title();
$bg = "bg-n";
$color = "color-n";
?>
	<div class="unique-pages">
		<div class="unique-text <?php echo $bg ?>">
		<h1><?php echo $tags_tit ?></h1>

<?php if ( is_user_logged_in() ) { ?>

		<p><?php _e('You have already logged in. Go to the home page to publish a message or to see the published message.','whatif'); ?></p>

<?php } else {
	// login form
	if ( array_key_exists('fail', $_GET) ) { $fail = sanitize_text_field($_GET['fail']); } else { $fail = ""; }
	if ( array_key_exists('login', $_GET) ) { $logerror = sanitize_text_field($_GET['login']); } else { $logerror = ""; }
	if ( array_key_exists('ref', $_GET) ) { $perma = sanitize_text_field($_GET['ref']); } else { $perma = ""; }
	
	$login_out = "
	<div class='user-form' id='login-form'>
	<form action='".WHATIF_BLOGURL."/login' method='post'>
	";
	if ( $logerror != '' ) {
		$login_message = __('Incorrect username or password','whatif');
		$login_out .= "<input class='login-caja message' type='text' name='nombre' value='" . $login_message . "' onblur=\"if(this.value == '') {this.value = '" . $login_message . "';}\" onfocus=\"if(this.value == '" . $login_message . "') {this.value = '';}\" />";
	} else {
		$login_message = __('Username','whatif');
		$login_out .= "<input class='login-caja ".$color."' type='text' name='nombre' value='" . $login_message . "' onblur=\"if(this.value == '') {this.value = '" . $login_message . "';}\" onfocus=\"if(this.value == '" . $login_message . "') {this.value = '';}\" />";
	}
		$pass_message = __('Password','whatif');
	$login_out .= "
		<input class='login-caja ".$color."' type='password' name='pass' value='" . $pass_message . "' onblur=\"if(this.value == '') {this.value = '" . $pass_message . "';}\" onfocus=\"if(this.value == '" . $pass_message . "') {this.value = '';}\" />
		<input type='hidden' name='ref' value='".$perma."' />
		<input class='login-boton ".$color."' type='submit' value='" . __('Log in','whatif') . "' name='login' />
		<fieldset class='login-check'><label>" . __('Remember me','whatif') . "</label>
			<input type='checkbox' name='remember' value='true' />
		</fieldset>

	</form>
	</div>
	";

	$reg_out = "
	<div class='user-form' id='reg-form'>
		<h3>" . __("If you're not registered yet:",'whatif') . "</h3>
	<form action='".WHATIF_BLOGURL."/registro' method='post'>
	";
	if ( $fail == 'name' ) { $reg_message = __('That username already exists','whatif'); $reg_out .="<input class='login-caja error' type='text' name='nombre' value='" . $reg_message . "' onblur=\"if(this.value == '') {this.value = '" . $reg_message . "';}\" onfocus=\"if(this.value == '" . $reg_message . "') {this.value = '';}\" />"; }
	else { $reg_message = __('Username','whatif'); $reg_out .="<input class='login-caja ".$color."' type='text' name='nombre' value='" .$reg_message. "' onblur=\"if(this.value == '') {this.value = '" .$reg_message. "';}\" onfocus=\"if(this.value == '" .$reg_message. "') {this.value = '';}\" />"; }
	$reg_out .= "<span>" . __('No spaces','whatif') . "</span>";

	if ( $fail == 'mail' ) { $reg_message = __('This email is already in use by other user','whatif'); $reg_out .="<input class='login-caja error' type='text' name='mail' value='" .$reg_message. "' onblur=\"if(this.value == '') {this.value = '" .$reg_message. "';}\" onfocus=\"if(this.value == '" .$reg_message. "') {this.value = '';}\" />"; }
	else { $reg_message = __('e-mail','whatif'); $reg_out .= "<input class='login-caja ".$color."' type='text' name='mail' value='" .$reg_message. "' onblur=\"if(this.value == '') {this.value = '" .$reg_message. "';}\" onfocus=\"if(this.value == '" .$reg_message. "') {this.value = '';}\" />"; }

	$reg_out .= "
		<input class='login-caja ".$color."' type='password' name='pass' value='' />
		<span>" . __('Password','whatif') . "</span>
		<input class='login-caja ".$color."' type='password' name='pass2' value='' />
	";
	if ( $fail == 'pass' ) { $reg_out .= "<span class='error'>" .__('Looks like you made a mistake while typing','whatif'). "</span>"; }
	else { $reg_out .= "<span>" . __('Confirm your password','whatif') . "</span>"; }

	$reg_out .=  "
		<input type='hidden' name='ref' value='".$perma."' />
		<input class='login-boton ".$color."' type='submit' value='" . __('Sign up','whatif') . "' name='registro' />
	</form>
	</div>
	";

	if ( array_key_exists('signup', $_GET) && sanitize_text_field($_GET['signup']) == 'success' ) {
		echo "<p>" .__('You are already registered. Now you can log in using your username and password.','whatif'). "</p>";
		$reg_out = "";
	}


	echo $login_out;
	echo $reg_out;

} // end if user is logged in ?>

		</div>
	</div>

<?php get_footer(); ?>
