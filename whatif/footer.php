</div><!-- end id central -->
<hr />
  

<div id="epi">
<?php
	// left links
	$lf_out = "<ul class='epi-lf'>";
	$lf_out .= "<li id='epi-home'><a href='" .WHATIF_BLOGURL. "'>" . __('Home page','whatif') . "</a></li>";
	$lf_out .= "</ul>";
	// right links
		$rt_out = "<ul class='epi-rt'>";
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();
		$user_name = $current_user->user_login;
		$rt_out .= "<li id='epi-user-mess'><a href='" .WHATIF_BLOGURL. "/author/$user_name'>" . __('My messages','whatif') . "</a></li>";
		$rt_out .= "<li id='epi-user-perfil'><a href='" .WHATIF_BLOGURL. "/wp-admin/profile.php'>" . __('My profile','whatif') . "</a></li>";
		$rt_out .= "<li id='epi-logout'><a href='" .WHATIF_BLOGURL. "/logout?ref=" .WHATIF_BLOGURL. "'>" . __('Log out','whatif') . "</a></li>";
	} else {
		$rt_out .= "<li id='epi-login'><a href='" .WHATIF_BLOGURL. "/user-sesion'>" . __('Log in','whatif') . "</a></li>";
	}
		$rt_out .= "</ul>";

	echo $lf_out;
	echo $rt_out;


$vistas_id = get_page_id("vistas");
if ( is_home() ) {
	$menu = "f-home";
	$arrgs = array(
		'theme_location' => $menu,
		'container' => '',
		'menu_class' => 'epi-menu',
	);
	wp_nav_menu( $arrgs );
}
elseif ( is_page() && $post->post_parent == $vistas_id || is_author() || is_tax() || is_single() ) {
	$menu = "f-vistas";
	$arrgs = array(
		'theme_location' => $menu,
		'container' => '',
		'menu_class' => 'epi-menu',
	);
	wp_nav_menu( $arrgs );
}?>

</div>
</div><!-- end id super -->

<?php wp_footer(); ?>

</body>
</html>
