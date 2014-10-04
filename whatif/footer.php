</div><!-- end id central -->
<hr />
  

<div id="epi">
<?php
	// left links
	$lf_out = "<ul class='epi-lf'>";
	$lf_out .= "<li><a href='" .WHATIF_BLOGURL. "'><img src='" .WHATIF_BLOGTHEME. "/images/epi-home.png' alt='" . __('Inicio','whatif') . "' />" . __('Inicio','whatif') . "</a></li>";
	if ( is_home() ) { // home
	$lf_out .= "<li><a href='http://whatif.es' target='_blank'><img src='" .WHATIF_BLOGTHEME. "/images/logowhatif.png' height='42px' alt='whatif.es'/>whatif.es</a></li>";
	}
	$lf_out .= "</ul>";
	// right links
		$rt_out = "<ul class='epi-rt'>";
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();
		$user_name = $current_user->user_login;
		$rt_out .= "<li><a href='" .WHATIF_BLOGURL. "/author/$user_name'><img src='" .WHATIF_BLOGTHEME. "/images/epi-user.png' alt='" . __('Mis mensajes','whatif') . "' />" . __('Mis mensajes','whatif') . "</a></li>";
		$rt_out .= "<li><a href='" .WHATIF_BLOGURL. "/wp-admin/profile.php'><img src='" .WHATIF_BLOGTHEME. "/images/epi-perfil.png' alt='" . __('Mi perfil','whatif') . "' />" . __('Mi perfil','whatif') . "</a></li>";
		$rt_out .= "<li><a href='" .WHATIF_BLOGURL. "/logout?ref=" .WHATIF_BLOGURL. "'><img src='" .WHATIF_BLOGTHEME. "/images/epi-logout.png' alt='" . __('Abandonar sesión','whatif') . "' />" . __('Abandonar sesión','whatif') . "</a></li>";
	} else {
		//$rt_out .= "<li><a href='" .WHATIF_BLOGURL. "/wp-login.php?redirect_to=" .WHATIF_BLOGURL. "'><img src='" .WHATIF_BLOGTHEME. "/images/epi-login.png' alt='" . __('Iniciar sesión','whatif') . "' /></a><br /><div>" . __('Iniciar sesión','whatif') . "</div></li>";
		$rt_out .= "<li><a href='" .WHATIF_BLOGURL. "/user-sesion'><img src='" .WHATIF_BLOGTHEME. "/images/epi-login.png' alt='" . __('Iniciar sesión','whatif') . "' />" . __('Iniciar sesión','whatif') . "</a></li>";
	}
		$rt_out .= "</ul>";

	echo $lf_out;
	echo $rt_out;


$vistas_id = get_page_id("vistas");
if ( is_home() ) { // home
	$menu = "f-home";
	$arrgs = array(
		'theme_location' => $menu,
		'container' => '',
		'menu_class' => 'epi-menu',
	);
}
elseif ( is_page() && $post->post_parent == $vistas_id ) { // vistas
//elseif ( is_page($pag_ids) ) { // vistas
//elseif ( is_page(array(get_page_id("mensajes"),get_page_id("localizaciones"))) ) { // vistas
	$menu = "f-vistas";
	$arrgs = array(
		'theme_location' => $menu,
		'container' => '',
		'menu_class' => 'epi-menu',
	);
} else { $menu = ""; }

if ( $menu != '' ) { ?>
		<?php wp_nav_menu( $arrgs ); ?>
<?php } ?>

</div>
</div><!-- end id super -->

<?php wp_footer(); ?>


</body>
</html>
