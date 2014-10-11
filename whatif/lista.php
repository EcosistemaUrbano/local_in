<?php
/*
Template Name: Lista
*/

get_header();

// GET vars
if ( array_key_exists('tagpn', $_GET) ) { $tagpn = sanitize_text_field( $_GET['tagpn'] ); } else { $tagpn = ""; }
if ( array_key_exists('tag2', $_GET) ) { $tag2 = sanitize_text_field( $_GET['tag2'] ); } else { $tag2 = ""; }

if ( array_key_exists('filtro', $_GET) ) { $filtro = sanitize_text_field( $_GET['filtro'] ); } else { $filtro = ""; }
if ( array_key_exists('pn', $_GET) ) { $pn = sanitize_text_field( $_GET['pn'] ); } else { $pn = ""; }

$valor=$pn;
$valor_query = "";
$valor_terms = get_terms($valor);
$count2 = 0;
foreach ( $valor_terms as $term ) {
	$count2++;
	if ( $count2 == 1) { $valor_query .= "$term->slug"; }
	else { $valor_query .= ",$term->slug"; }
}

// this page title
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		include "vistas-list.php";
	endwhile;
else:
endif;
wp_reset_query(); ?>


<div id="dosificador">
<?php // list of messages
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if ($tagpn!="") {
   $valor = $tagpn;
   $valor_query = $tag2;
	query_posts( "posts_per_page=3&paged=$paged&$valor=$valor_query&cat=$filtro&orderby=meta_value_num&order=DESC" );

} else {
	query_posts( "posts_per_page=3&paged=$paged&$valor=$valor_query&cat=$filtro&orderby=meta_value_num&order=DESC" );

}

$count_posts = wp_count_posts();
$published_posts = $count_posts->publish;


if ( have_posts() ) : ?>
	<div class="navigation navigation-left alignleft"><?php previous_posts_link(__('Entradas anteriores','whatif'),'') ?></div>
	<div id='deslizante'>

	<?php while ( have_posts() ) : the_post();
	$post_ID = get_the_ID();
	$mess_author = get_the_author(); // the author
	$mess_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

	$mess_date = get_the_time('j\.n\.Y'); // the date
	$mess_content = get_the_content(); // the message
	$mess_perma = get_permalink(); // permanent link
	$mess_edit_link = get_edit_post_link(); // access to edit panel for this post
	$coor = get_post_meta($post->ID, "coordenadas", true);
	$positivonegativo = get_post_meta($post->ID, "positivonegativo", true);
    $video = get_post_meta($post->ID, "video", $single = true);
    $comentario = __('Permalink','whatif');
    $tituloenviar =  substr($mess_content,0,20); 
    $tituloenviarurl = str_replace(" ","-",$tituloenviar);
	 $videomuestra=" | <a target='_blank' href='$video'>". __('Ver Video','whatif') . "</a>";
	 
	  if($video=="" OR $video=="http://"){
	        $videomuestra="";
	  };
   
	 //  Sistema de votaciones
//global $wpdb;
//	$post_ID = get_the_ID();
//	$ip = $_SERVER['REMOTE_ADDR'];
//	
//    $liked = get_post_meta($post_ID, '_liked', true) != '' ? get_post_meta($post_ID, '_liked', true) : '0';
//	$voteStatusByIp = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."ilikethis_votes WHERE post_id = '$post_ID' AND ip = '$ip'");
//		
//    if (!isset($_COOKIE['liked-'.$post_ID]) && $voteStatusByIp == 0) {
//    	if (get_option('ilt_textOrImage') == 'image') {
//    		$counter = '<a title=\'votar\' onclick="likeThis('.$post_ID.');" class="image">'.$liked.'</a>';
//    	}
//    	else {
//    		$counter = $liked.' <a onclick="likeThis('.$post_ID.');">'.get_option('ilt_text').'</a>';
//    	}
//    }
//    else {
//    	$counter = $liked;
//    }
//    
//    $iLikeThis = '<div id="iLikeThis-'.$post_ID.'" class="iLikeThis">';
//    	$iLikeThis .= '<span class="counter">'.$counter.'</span>';
//    $iLikeThis .= '</div>';
//    
//    if ($arg == 'put') {
//	    return $iLikeThis;
//    }
//    else {
//    	//echo $iLikeThis;
//    	
//    	$votacion=$iLikeThis;
//	 }

	$votacion = "";
  // Fin sistema de votacion	 
	 
	if ( is_user_logged_in() ) { $mess_edit = " | <a href='$mess_edit_link'>". __('Editar','whatif') . "</a>"; }
	else { $mess_edit = ""; }

	// the categories
	$mess_cats = "<ul class='messSingle-cats'>";
	foreach ( get_the_category() as $categ ) {
		$categoryID = $categ->term_id;
		$categLink = get_category_link($categ->term_id);

		$cat_meta = get_option( "taxonomy_$categoryID" );
		if ( is_array($cat_meta) ) {
			if ( array_key_exists('image',$cat_meta) && $cat_meta['image'] != '' ) {
				$cat_img = $cat_meta['image'];
			}
		} else { $cat_img = WHATIF_BLOGTHEME. "/images/default-cat.png"; }
		$categImg = "<img src='" .$cat_img. "' alt='" .$categ->name. "' />";
		$mess_cats .= "
			<li id='$categ->slug' class='messSingle-cat'>
			<a class='messSingle-cat-img' href='" .WHATIF_BLOGURL. "/vistas/mensajes?filtro=$categoryID&pn=$pn'>$categImg</a>
			<div class='mess-cat-tit'>
			<a href='" .WHATIF_BLOGURL. "/vistas/mensajes?filtro=$categoryID&pn=$pn'>$categ->name</a>
			</div>
			</li>
		";
	}
	$mess_cats .= "</ul><!-- end class mess-cats -->";

	// the image
	$args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $post->ID ); 
	$attachments = get_posts($args);
	if ( $attachments ) {
		foreach ( $attachments as $attachment ) {
			$image_link = get_attachment_link($attachment->ID). "?ref=list";
			$alt_attachment = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
			$imageurl = wp_get_attachment_image_src( $attachment->ID, 'thumbnail');
			$mess_img = "<div class='messSingle-img'><a href='" .$image_link. "'><img src='" .$imageurl[0]. "' alt='" .$alt_attachment. "' ></a></div>";

		}
	} else {
		$img_url = WHATIF_BLOGTHEME. "/images/default.png";
		$mess_img = "
		<div class='messSingle-img'>
			<img src='$img_url' alt='". __('Sin imagen','whatif') . "' />
		</div>
		";
	}

	// the tags
	$terms_pl = wp_get_post_terms( $post->ID, 'positivo' );
	$terms_mn = wp_get_post_terms( $post->ID, 'negativo' );
	

		$mess_tags = "<ul class='messSingle-tags'>";
	foreach ( $terms_pl as $term_pl ) {
	
         $term_pl->name = str_replace("á","a",$term_pl->name);
         $term_pl->name = str_replace("é","e",$term_pl->name);
         $term_pl->name = str_replace("í","i",$term_pl->name);
         $term_pl->name = str_replace("ó","o",$term_pl->name);
         $term_pl->name = str_replace("ú","u",$term_pl->name);		
      
		$term_link_pl = get_term_link("$term_pl->slug", 'positivo');
		$mess_tags .= "<li class='bg-p'><a href='" .WHATIF_BLOGURL. "/vistas/mensajes?tagpn=positivo&tag2=$term_pl->name'>$term_pl->name</a></li>"; 
		                                
	}
	foreach ( $terms_mn as $term_mn ) {
	
         $term_mn->name = str_replace("á","a",$term_mn->name);
         $term_mn->name = str_replace("é","e",$term_mn->name);
         $term_mn->name = str_replace("í","i",$term_mn->name);
         $term_mn->name = str_replace("ó","o",$term_mn->name);
         $term_mn->name = str_replace("ú","u",$term_mn->name);	
	
		$term_link_mn = get_term_link("$term_mn->slug", 'negativo');
		$mess_tags .= "<li class='bg-c'><a  href='" .WHATIF_BLOGURL. "/vistas/mensajes?tagpn=negativo&tag2=$term_mn->name'>$term_mn->name</a></li>";
	}
		$mess_tags .= "</ul>";

	echo "
	<div class='mess'>
		$mess_img
		<div class='messSingle-aut'>
			<div class='messSingle-meta'>
				<a href='$mess_author_link'>$mess_author</a> | $mess_date | <a href='$mess_perma?vista=map'>Ver localización</a>  $videomuestra
			</div>
			$votacion
			<div class='messSingle-social'>
				<a target='_blank' name='fb_share' type='button' href='http://www.facebook.com/share.php?u=$mess_perma'><img src='" .WHATIF_BLOGTHEME. "/images/ficon.png' /></a>
				<a target='_blank' href='http://twitter.com//?status=Estoy leyendo: $mess_content <a href=\"http://whatifcities.com/" .WHATIF_INSTALL_FOLDER. "/$tituloenviarurl\">$tituloenviar</a>' ><img src='" .WHATIF_BLOGTHEME. "/images/ticon.png' /></a>
				<a target='_blank' href='http://www.tuenti.com/share?url=$mess_perma' ><img src='" .WHATIF_BLOGTHEME. "/images/tuentiicon.png' /></a>
			</div>
			<div class='messSingle-extra'>
				<a href='$mess_perma'>$comentario</a>
				$mess_edit
			</div>
		</div>
		<div class='messSingle-text'>$mess_content</div>
		<div class='messSingle-context'>
		$mess_cats
		$mess_tags
		</div>
	</div>
	";
	endwhile; ?>
	</div><!-- #deslizante -->
	<div class="navigation navigation-right alignright"><?php next_posts_link(__('Entradas posteriores','whatif'),'') ?></div>
<?php endif;
wp_reset_query(); ?>
</div><!-- #dosificador -->


<?php // categories filters
include "filters.php";
	
get_footer(); ?>
