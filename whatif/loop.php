<?php
	$mess_author = get_the_author(); // the author
	$mess_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
	$mess_date = get_the_date(NULL,$mess_ID); // the date
	$mess_content = get_the_content($mess_ID); // the message
	$mess_content_escurl = urlencode($mess_content);
	$mess_perma = get_permalink($mess_ID); // permanent link
	$mess_perma_escurl = esc_url($mess_perma);
	$mess_edit_link = get_edit_post_link($mess_ID); // access to edit panel for this post
	$coor = get_post_meta($mess_ID, "coordenadas", true);
	$positivonegativo = get_post_meta($mess_ID, "positivonegativo", true);
	if ( $positivonegativo == 'positivo') { $bg_class = WHATIF_STYLE_POSITIVE_BG; }
	elseif ( $positivonegativo == 'negativo') { $bg_class = WHATIF_STYLE_NEGATIVE_BG; }
	$video = get_post_meta($mess_ID, "video", true);
	if($video == '' || $video == "http://" ){ $video_out = ""; }
	else { $video_out = "<a target='_blank' href='" .$video. "'>". __('View link','whatif') . "</a> | "; }

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
$votacion = whatif_vote_system_display_votes();
//$votacion = "";
// Fin sistema de votacion

	if ( current_user_can( 'edit_posts' ) ) { $mess_edit = " | <a href='$mess_edit_link'>". __('Edit','whatif') . "</a>"; }
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
			<a class='messSingle-cat-img' href='" .WHATIF_BLOGURL. "/vistas/mensajes?filtro=$categoryID'>$categImg</a>
			<div class='mess-cat-tit'>
				<a href='" .WHATIF_BLOGURL. "/vistas/mensajes?filtro=$categoryID'>$categ->name</a>
			</div>
		</li>
		";
	}
	$mess_cats .= "</ul><!-- end class mess-cats -->";

	// the image
	$args = array( 'post_type' => 'attachment', 'numberposts' => 1, 'post_status' => null, 'post_parent' => $mess_ID ); 
	$attachments = get_posts($args);
	if ( $attachments ) {
		foreach ( $attachments as $attachment ) {
			$image_link = get_attachment_link($attachment->ID). "?ref=".$ref_url;
			$alt_attachment = get_post_meta( $mess_ID, '_wp_attachment_image_alt', true );
			$imageurl = wp_get_attachment_image_src( $attachment->ID, 'thumbnail');
			$mess_img = "<div class='messSingle-img'><a href='" .$image_link. "'><img src='" .$imageurl[0]. "' alt='" .$alt_attachment. "' ></a></div>";
		}
	} else {
		$img_url = WHATIF_BLOGTHEME. "/images/default.png";
		$mess_img = "
		<div class='messSingle-img'>
			<img src='$img_url' alt='". __('No image','whatif') . "' />
		</div>
		";
	}

	// the tags
	$terms = wp_get_post_terms( $mess_ID, $positivonegativo );
	$mess_tags = "<ul class='messSingle-tags'>";
	foreach ( $terms as $term ) {
		$mess_tags .= "<li class='" .$bg_class. "'><a href='" .WHATIF_BLOGURL. "/vistas/mensajes?tagpn=" .$positivonegativo. "&tag2=$term->slug'>$term->name</a></li>"; 
	}
	$mess_tags .= "</ul>";


	$mess_out .= "
	<div class='mess'>
		" .$mess_img. "
		<div class='messSingle-aut'>
			<ul class='messSingle-meta'>
				<li><a href='" .$mess_author_link. "'>" .$mess_author. "</a></li>
				<li>" .$mess_date. "</li>
				<li><a href='" .$mess_perma. "?vista=map'>" .__('View location','whatif'). "</a></li>
				" .$video_out. "
				<li><a href='" .$mess_perma. "'>" .__('Permalink','whatif'). "</a></li>
			</ul>
			" .$votacion. "
			<ul class='messSingle-social'>
				<li><a target='_blank' href='http://facebook.com/sharer.php?u=".$mess_perma_escurl."' title='" .__('Share on Facebook','whatif')."'>f</a></li>
				<li><a target='_blank' href='http://twitter.com/home?status=".$mess_content_escurl." ".$mess_perma_escurl."' title='" .__('Share on Twitter','whatif')."'>t</a></li>
				<li><a target='_blank' href='https://plus.google.com/share?url=".$mess_perma_escurl."' title='" .__('Share on Google Plus','whatif')."'>g+</a></li>
			</ul>
			" .$mess_edit. "
		</div>
		<div class='messSingle-text'>$mess_content</div>
		<div class='messSingle-context'>
			$mess_cats
			$mess_tags
		</div>
	</div>
	";

?>
