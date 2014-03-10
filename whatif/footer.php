</div><!-- end id central -->
<hr />
  

<div id="epi">



<?php include "general-vars.php";



	// left links
	$lf_out = "<ul class='epi-lf'>";
	$lf_out .= "<li><a href='$home'><img src='$template_url/images/epi-home.png' alt='" . __('Inicio','whatif') . "' /></a><br /><div>" . __('Inicio','whatif') . "</div></li>";
	if ( is_home() ) { // home
	$lf_out .= "<li><a href='http://whatif.es' target='_blank'><img src='$template_url/images/logowhatif.png' height='42px' alt='whatif.es'/></a><div>whatif.es</div><br></li>";
	}
	$lf_out .= "</ul>";
	// right links
		$rt_out = "<ul class='epi-rt'>";
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();
		$user_name = $current_user->user_login;
		$rt_out .= "<li><a href='$home/author/$user_name?buscauthor=$user_name'><img src='$template_url/images/epi-user.png' alt='" . __('Mis mensajes','whatif') . "' /></a><br /><div>" . __('Mis mensajes','whatif') . "</div></li>";
		$rt_out .= "<li><a href='$home/wp-admin/profile.php'><img src='$template_url/images/epi-perfil.png' alt='" . __('Mi perfil','whatif') . "' /></a><br /><div>" . __('Mi perfil','whatif') . "</div></li>";
		$rt_out .= "<li><a href='$home/logout?ref= $home '><img src='$template_url/images/epi-logout.png' alt='" . __('Abandonar sesión','whatif') . "' /></a><br /><div>" . __('Abandonar sesión','whatif') . "</div></li>";
	} else {
		$rt_out .= "<li><a href='$home/wp-login.php?redirect_to=$home'><img src='$template_url/images/epi-login.png' alt='" . __('Iniciar sesión','whatif') . "' /></a><br /><div>" . __('Iniciar sesión','whatif') . "</div></li>";
	}
		$rt_out .= "</ul>";

	echo $lf_out;
	echo $rt_out;


$vistas_id = get_page_id("vistas");
//$vistas_childs = get_pages("child_of=$vistas_id&parent=$vistas_id");
//$count = 0;
//$pag_ids = array();
//foreach ( $vistas_childs as $pag ) {
//	$count++;
//	if ( $count == 1 ) { $pag_ids = "$pag->ID"; }
//	else { $pag_ids .= ",$pag->ID"; }
//	$pag_ids .= "$pag->ID";
//}
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
}

if ( $menu != '' ) {
//		$menu_out = "<ul class='epi-menu'>";
//	$items = wp_get_nav_menu_items($menu);
?>
	<div class="epi-menu">
		<?php wp_nav_menu( $arrgs ); ?>
	</div>

<?php
//	echo $items;
//	foreach ( $items as $item ) {
//		$item_link = get_page_link($item->object_id);
//		$menu_out .= "<li><a href='$item_link'>$item->slug</a></li>";
//
//	}
//		$menu_out .= "</ul>";
//	echo $menu_out;
}


?>

</div>

</div><!-- end id super -->

<?php wp_footer(); ?>


</body>
</html>
