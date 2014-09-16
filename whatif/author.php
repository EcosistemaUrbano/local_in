<?php

get_header();

include "general-vars.php";

// avatar and other info about the author
if(isset($_GET['author_name'])) { $cur_aut = get_userdatabylogin(get_the_author_login()); }
else { $cur_aut = get_userdata(intval($author)); }
	$cur_aut_name = 
	$aut = $cur_aut->ID;
// var to generate custom avatar for users
//	$avtr = get_avatar( $cur_aut->ID );
	$aut_web = $cur_aut->user_url;
	if ( $aut_web != '' ) {
		$aut_datos = "
			<ul class='aut-meta'>
				<li><strong>" . __('Datos:','whatif') . "</strong></li>
				<li><a href='$cur_aut->user_url'>Web personal</a></li>
			</ul>
		";
	} else { $aut_datos = ""; }
// this page title
	$tit_out = "
		<div class='tit-peq'>
			<img alt='User avatar' src='$template_url/images/miavatar.png' />
			<h2>" . __('Mensajes enviado por','whatif') . " <span style='font-size:22px; font-weight:bold;'>$cur_aut->user_login</span></h2>
			$aut_datos	
		</div>
	";

// code to generate custom avatar for users
//if ( post_custom("Page Small Icon") ) { $pag_img = get_post_meta($post->ID, "Page Small Icon", $single = true); }
//	$tit_out = "
//	<div class='tit-peq'>
//		<img src='$pag_img' alt='$tags_tit' />
//		<h2>$tags_tit</h2>
//	</div>
//	";
//

echo $tit_out; //display header
?>	
<div class="vista-selector-mini">
	
	<div class="vista-img-mini">
		<a href="http://<?php echo $wic ?>/<?php echo $citymin ?>/vistas/localizaciones/"><img alt="<?php _e('Localizaciones','whatif'); ?>" src="<?php echo $template_url ?>/images/vista-localiza-mini.png"></a>
	</div>
	
	<div class="vista-img-mini">
		<a href="http://<?php echo $wic ?>/<?php echo $citymin ?>/vistas/palabras-clave/"><img alt="<?php _e('Palabras clave','whatif'); ?>" src="<?php echo $template_url ?>/images/vista-tags-mini.png"></a>
	</div>
	
	<div class="vista-img-mini">
		<a href="http://<?php echo $wic ?>/<?php echo $citymin ?>/vistas/imagenes/"><img alt="<?php _e('Imágenes','whatif'); ?>" src="<?php echo $template_url ?>/images/vista-images-mini.png"></a>
	</div>
</div><!-- end .vista-selector-mini -->
	
<?php	
	// list of messages for this author
	include "loop.php";

get_footer(); ?>
