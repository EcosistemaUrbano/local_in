<?php
$vistas_id = get_page_id("vistas");
// vistas list (subpages)
$args = array(
	'post_type' => 'page',
	'post_parent' => $vistas_id,
	'order_by' => 'menu_order',
	'order' => 'ASC'
);
$children = get_posts($args);

$vistas_out = "<div class='vista-selector-mini'>";
	
foreach ( $children as $child ) {
	$pag_child_link = get_permalink($child->ID);
	$pag_child_tit = get_the_title($child->ID);
	if ( has_post_thumbnail($child->ID) ) { $pag_child_img = get_the_post_thumbnail( $child->ID, "icon"); }
	else { $pag_child_img = "<img src='" .WHATIF_BLOGTHEME. "/images/default-view.png' alt='" .$pag_child_tit. "' />"; }
	if ( $child->ID == $post->ID ) {
		$vistas_out .= "
		<div class='vista-img-mini'>
			" .$pag_child_img. "
			<img class='vista-active' src='" .WHATIF_BLOGTHEME. "/images/view-active.png' alt='" .__('Active view','whatif'). "' />
		</div>
		";
		$tit_out = "
		<div class='tit-peq'>
			$pag_child_img
			<h2>$pag_child_tit</h2>
		</div>
		";
	} else {
		$vistas_out .= "
		<div class='vista-img-mini'>
			<a href='$pag_child_link'>$pag_child_img</a>
		</div>
		";
	}
}

$vistas_out .= "</div><!-- end class vista-selector-mini -->";

if ( is_author() ) { // if author page
	$cur_aut = get_userdata(intval($author));
	$aut_web = $cur_aut->user_url;
	if ( $aut_web != '' ) {
		$aut_datos = "
		<ul class='aut-meta'>
			<li><strong>" . __('Website','whatif') . "</strong>: <a href='" .$cur_aut->user_url. "'>" .$cur_aut->user_url. "</a></li>
		</ul>
		";
	} else { $aut_datos = ""; }
	// this page title
	$tit_out = "
	<div class='tit-peq'>
		<img alt='User avatar' src='" .WHATIF_BLOGTHEME. "/images/default-user.png' />
		<h2>" . sprintf(__('Messages sent by %s','whatif'),$cur_aut->user_login ). "</h2>
			" .$aut_datos. "
		</div>
	";

} elseif ( is_tax() )  { // if term page
	$term =	$wp_query->queried_object->name;
	$tit_out = "
	<div class='tit-peq'>
		<img alt='User avatar' src='" .WHATIF_BLOGTHEME. "/images/default-view.png' />
		<h2>" . sprintf(__('Message with the keyword "%s"','whatif'),$term ). "</h2>
		</div>
	";
} elseif ( is_single() ) {
	$tit_out = "";
}

echo $tit_out;
echo $vistas_out;
?>
