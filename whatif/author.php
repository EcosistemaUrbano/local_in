<?php
get_header();

$ref_url = "user";

// FILTERS
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

if ($tagpn!="") {
   $valor = $tagpn;
   $valor_query = $tag2;
}
// END FILTERS

include "vistas-list.php";
?>

	<div id='dosificador'>
<div class="navigation navigation-left alignleft"><?php previous_posts_link(__('Entradas anteriores','whatif'),'') ?></div>
	<div id='deslizante'>
<?php
$mess_out = "";

if ( have_posts() ) {

	while ( have_posts() ) : the_post();

	$mess_ID = get_the_ID();
	$user_ID = get_current_user_id();
	$mess_author_ID = $post->post_author;
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
	else { $video_out = " | <a target='_blank' href='" .$video. "'>". __('Ver Video','whatif') . "</a>"; }

	$votacion = "";
//	if ( is_user_logged_in() ) {
	if ( current_user_can( 'edit_posts' ) ) { $mess_edit = " | <a href='$mess_edit_link'>". __('Editar','whatif') . "</a>"; }
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
			<img src='$img_url' alt='". __('Sin imagen','whatif') . "' />
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
				<li><a href='" .$mess_perma. "?vista=map'>" .__('Ver localización','whatif'). "</a></li>
				" .$video_out. "
				<li><a href='" .$mess_perma. "'>" .__('Permalink','whatif'). "</a></li>
			</ul>
			" .$votacion. "
			<ul class='messSingle-social'>
				<li><a target='_blank' href='http://facebook.com/sharer.php?u=".$mess_perma_escurl."' title='" .__('Compartir en Facebook','whatif')."'>f</a></li>
				<li><a target='_blank' href='http://twitter.com/home?status=".$mess_content_escurl." ".$mess_perma_escurl."' title='" .__('Compartir en Twitter','whatif')."'>t</a></li>
				<li><a target='_blank' href='https://plus.google.com/share?url=".$mess_perma_escurl."' title='" .__('Compartir en Google Plus','whatif')."'>g+</a></li>
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

	endwhile;
?>
<?php echo $mess_out; ?>
</div>
<div class="navigation navigation-right alignright"><?php next_posts_link(__('Entradas posteriores','whatif'),'') ?></div>
</div>

<?php } else { echo __('Este usuario no ha publicado nada aún.','whatif'); }

get_footer(); ?>
