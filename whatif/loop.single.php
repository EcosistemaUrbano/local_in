<?php
$mess_out = "<div class='unique-pages-tit lista'>";

$post_ID = get_the_ID();
$nombre =get_permalink();

	$mess_author = get_the_author(); // the author
	$mess_author_link = WHATIF_BLOGURL."/author/$mess_author"; // the author page link
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
//    		$counter = '<a onclick="likeThis('.$post_ID.');" class="image">'.$liked.'</a>';
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
		//$categDesc = category_description($categ->term_id);
		if ( function_exists('get_cat_icon') ) {
			$categImg = get_cat_icon("cat=$categoryID&echo=false&link=false&small=true&fit_width=20&fit_height=20");
		} else { $categImg = ""; }
		$mess_cats .= "
			<li id='$categ->slug' class='messSingle-cat'>
			$categImg
			<div class='mess-cat-tit'>
			<a href='" .WHATIF_BLOGURL. "/vistas/mensajes?filtro=$categoryID'>$categ->name</a>
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
			//$imagenLink = wp_get_attachment_link($attachment->ID, 'thumbnail', true);	
			$image_link = get_attachment_link($attachment->ID). "?ref=message";
			$alt_attachment = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
			$imageurl = wp_get_attachment_image_src( $attachment->ID, 'thumbnail');
			$mess_img = "<div class='messSingle-img'><a href='" .$image_link. "'><img src='" .$imageurl[0]. "' alt='" .$alt_attachment. "' ></a></div>";

			//$mess_img = "<div class='messSingle-img'>" .$imagenLink. "</div>";
		}
	} else {
		$img_url = WHATIF_BLOGTHEME."/images/default.png";
		$mess_img = "<div class='messSingle-img'><img src='$img_url' alt='". __('Sin imagen','whatif') . "' /></div>";
	}

	// the tags
	$terms_pl = wp_get_post_terms( $post->ID, 'positivo' );
	$terms_mn = wp_get_post_terms( $post->ID, 'negativo' );
		$mess_tags = "<ul class='messSingle-tags'>";
	foreach ( $terms_pl as $term_pl ) {
		$term_link_pl = get_term_link("$term_pl->slug", 'positivo');
		$mess_tags .= "<li class='bg-p'><a  href='" .WHATIF_BLOGURL. "/vistas/mensajes?tagpn=positivo&tag2=$term_pl->name'>$term_pl->name</a></li>"; 
		                                
	}
	foreach ( $terms_mn as $term_mn ) {
		$term_link_mn = get_term_link("$term_mn->slug", 'negativo');
		$mess_tags .= "<li class='bg-c'><a  href='" .WHATIF_BLOGURL. "/vistas/mensajes?tagpn=negativo&tag2=$term_mn->name'>$term_mn->name</a></li>";
	}
		$mess_tags .= "</ul>";

$mess_out .= "
	<div class='messSingle'>
		$mess_img
		<div class='messSingle-aut'>
			<div class='messSingle-meta'>
				<a href='$mess_author_link'>$mess_author</a> | $mess_date | <a href='" .WHATIF_BLOGURL. "/msgmap?coor=$coor&cat=$categoryID&pos=$positivonegativo&id=$post_ID'>Ver localización</a>  $videomuestra
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

$mess_out .= "</div><!-- end class unique -->";

?>

  <div class="tit-peq"><h2><?php _e('what if...? cities','whatif'); echo " | ". get_the_title(); ?></h2></div>


<?php
echo $mess_out;
?>
