<?php


get_header(); 

?>

<style type="text/css">
#epi 
{
 top:77px;
}
#contieneajax
{
 top:-20px;
}
.filter-cats
{
top:140px;
}
</style>
<?php

 $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
  $taxonomy = get_query_var( 'taxonomy' );

 $valor_query_term =  $term->name; 
 $valor_term = $term->taxonomy; 



$alltax = $_GET['alltax']; // to know if positivo or negativo list
if ( is_author() ) {
//query_posts("author=$cur_aut->ID&showposts=3&posts_per_page=3&paged=$paged");
}
elseif ( $alltax != '' ) {
	$alltags = get_terms($alltax);
	$tax_terms = "";
	foreach ( $alltags as $alltag ) { $tax_terms .= "$alltag->slug,"; }
	query_posts("$alltax=$tax_terms&post_per_page=18&orderby=date&order=DESC");
	
//	echo "bingo";
}
else {
	$categ = $_GET['categ'];
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	if ( $categ == '' ) { query_posts("posts_per_page=18&paged=$paged"); }
	else { query_posts("posts_per_page=18&paged=$paged&category_name=$categ"); }
}
if ( have_posts() ) :
$mess_out = "
  
    <div id='contieneajax'>
	<div id='dosificadorMess'>
	<div class='controlMess' id='leftControlMess' title='" . __('Paso anterior','whatif') . "'>&laquo;</div>
	<div id='deslizanteMess'>
";

$count_a = -1;
$count = 0;


$tagpn="";
$tagpn=$_GET['tagpn'];
$tag2=$_GET['tag2'];

$filtro=$_GET['filtro'];
$pn=$_GET['pn'];
$pn2="";
$pn2=$_GET['pn2'];

$plvaria = "pl-mini.png";
$mnvaria = "mn-mini.png";

if ($pn == "positivo" AND $pn2=="positivo")
{ $plvaria="pl-mini.png";
 
}
if ($pn == "negativo" AND $pn2=="negativo")
{ $mnvaria="mn-mini.png";
 
}


if ($pn == "positivo" AND $pn2!="positivo")
{
$pn2="positivo";
$plvaria="pl-big.png";
}

if ($pn == "negativo" AND $pn2!="negativo" )
{
$pn2="negativo"; 
$mnvaria = "mn-big.png";
}


$valor=$pn;
$valor_query = "";
$valor_terms = get_terms($valor);
$count2 = 0;
foreach ( $valor_terms as $term ) {
$count2++;
if ( $count2 == 1) { $valor_query .= "$term->slug"; }
else { $valor_query .= ",$term->slug"; }
}


if ($tagpn!="")

{
   $valor = $tagpn;
   $valor_query = $tag2;
   
  // query_posts( "meta_key=_liked&posts_per_page=-1&$valor=$valor_query&cat=$filtro&orderBy=meta_value_num&order=DESC" );
   
   query_posts( "posts_per_page=18&$valor=$valor_query&cat=$filtro&orderBy=meta_value_num&order=DESC" );
}

else

$valor = $valor_term;
$valor_query = $valor_query_term;

{

 query_posts( "posts_per_page=18&$valor=$valor_query&cat=$filtro&orderBy=meta_value_num&order=DESC" );
 
 
  //query_posts( "meta_key=_liked&posts_per_page=-1&positivo=comercio&cat=$filtro&orderBy=meta_value_num&order=DESC" );
 
}




while ( have_posts() ) : the_post();


	$count_a++;
	$count++;
//	$abrir = $abrir + $inc;
//	$cerrar = $cerrar + $inc;
if ( $count_a == 0 || $count_a % 3 == 0 ) {

  

//if ( $count_a == 0 || $count_a == 3 || $count_a == 6) {
	$mess_out .= "<div class='unique lista deslizaMess'>";
//	$test = $count % 3;
//	$mess_out .= $test;
}

$post_ID = get_the_ID();

	$mess_author = get_the_author(); // the author
	$mess_author_link = "$home/author/$mess_author"; // the author page link
	$mess_date = get_the_time('j\.n\.Y'); // the date
	$mess_content = get_the_content(); // the message
	$mess_perma = get_permalink(); // permanent link
	$mess_edit_link = get_edit_post_link(); // access to edit panel for this post
	$coor = get_post_meta($post->ID, "coordenadas", true);
	$positivonegativo = get_post_meta($post->ID, "positivonegativo", true);
    $video = get_post_meta($post->ID, "video", $single = true);
    $comentario = __('Comentario','whatif') .$post_ID;
    $comentario = __('Permalink','whatif');
    $tituloenviar =  substr($mess_content,0,20); 
    $tituloenviarurl = str_replace(" ","-",$tituloenviar);
    
	 
	 $videomuestra=" | <a target='_blank' href='$video'>". __('Ver Video','whatif') . "</a>";
	 
	  if($video=="" OR $video=="http://"){
	        $videomuestra="";
	  };
   

	
	
	 //  Sistema de votaciones
	 
	 
global $wpdb;
	$post_ID = get_the_ID();
	$ip = $_SERVER['REMOTE_ADDR'];
	
    $liked = get_post_meta($post_ID, '_liked', true) != '' ? get_post_meta($post_ID, '_liked', true) : '0';
	$voteStatusByIp = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."ilikethis_votes WHERE post_id = '$post_ID' AND ip = '$ip'");
		
    if (!isset($_COOKIE['liked-'.$post_ID]) && $voteStatusByIp == 0) {
    	if (get_option('ilt_textOrImage') == 'image') {
    		$counter = '<a title=\'votar\' onclick="likeThis('.$post_ID.');" class="image">'.$liked.'</a>';
    	}
    	else {
    		$counter = $liked.' <a onclick="likeThis('.$post_ID.');">'.get_option('ilt_text').'</a>';
    	}
    }
    else {
    	$counter = $liked;
    }
    
    $iLikeThis = '<div id="iLikeThis-'.$post_ID.'" class="iLikeThis">';
    	$iLikeThis .= '<span class="counter">'.$counter.'</span>';
    $iLikeThis .= '</div>';
    
    if ($arg == 'put') {
	    return $iLikeThis;
    }
    else {
    	//echo $iLikeThis;
    	
    	$votacion=$iLikeThis;
	 }
  // Fin sistema de votacion	 
	 
	
	if ( is_user_logged_in() ) { $mess_edit = " | <a href='$mess_edit_link'>". __('Editar','whatif') . "</a>"; }
	else { $mess_edit = ""; }

	// the categories
	$mess_cats = "<ul class='mess-cats'>";
	foreach ( get_the_category() as $categ ) {
		$categoryID = $categ->term_id;
		$categLink = get_category_link($categ->term_id);
		//$categDesc = category_description($categ->term_id);
		if ( function_exists('get_cat_icon') ) {
			$categImg = get_cat_icon("cat=$categoryID&echo=false&link=false&small=true&fit_width=20&fit_height=20");
		}
		$mess_cats .= "
			<li id='$categ->slug' class='mess-cat'>
			$categImg
			<div class='mess-cat-tit'>
			<a href='$home/vistas/mensajes?filtro=$categoryID&pn=$pn2'>$categ->name</a>
			</div>
			</li>
		";
	}
	$mess_cats .= "</ul><!-- end class mess-cats -->";

	// the image
	$args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $post->ID ); 
	$attachments = get_posts($args);
//	if ( has_post_thumbnail() ) {
	if ( $attachments ) {
//		$img = get_the_post_thumbnail($post->ID, 'thumbnail');

		foreach ( $attachments as $attachment ) {
			//$img =  apply_filters( 'the_title' , $attachment->post_title );
			//$img_link =  $attachment->guid;
	    $img_link=  wp_get_attachment_url( $post_ID );
	    
		    $imagenLink = wp_get_attachment_link($attachment->ID, 'thumbnail');	
			//$img_thumb = wp_get_attachment_image($attachment->ID, 'thumbnail');
		$mess_img = "
		<div class='mess-img'>
		
		$imagenLink
			
			
			
		</div>
		";

		}
	} else {
		$img_url = "$template_url/images/default.png";
		$mess_img = "
		<div class='mess-img'>
			<img src='$img_url' alt='". __('Sin imagen','whatif') . "' />
		</div>
		";
	}

	// the tags
	$terms_pl = wp_get_post_terms( $post->ID, 'positivo' );
	$terms_mn = wp_get_post_terms( $post->ID, 'negativo' );
		$mess_tags = "<ul class='mess-tags'>";
	foreach ( $terms_pl as $term_pl ) {
		$term_link_pl = get_term_link("$term_pl->slug", 'positivo');
		$mess_tags .= "<li class='bg-p'><a  href='$home/vistas/mensajes?tagpn=positivo&tag2=$term_pl->name'>$term_pl->name</a></li>"; 
		                                
	}
	foreach ( $terms_mn as $term_mn ) {
		$term_link_mn = get_term_link("$term_mn->slug", 'negativo');
		$mess_tags .= "<li class='bg-c'><a  href='$home/vistas/mensajes?tagpn=negativo&tag2=$term_mn->name'>$term_mn->name</a></li>";
	}
		$mess_tags .= "</ul>";

if ( is_author() ) { // if author page
$mess_out .= "
	<div class='mess'>
	    $mess_img
		<div class='mess-aut'><div style='float:left'><a href='$mess_author_link'>$mess_author</a> | $mess_date | <a href='$home/msgmap?coor=$coor&cat=$categoryID&pos=$positivonegativo&id=$post_ID'>Ver localización</a>  $videomuestra</div>$votacion <div class='socialmedia'> <a target='_blank' name='fb_share' title='facebook' type='button' href='http://www.facebook.com/share.php?u=$mess_perma'><img src='$template_url/images/ficon.png' /></a></script><a target='_blank' title='twitter' href='http://twitter.com/home/?status=Estoy leyendo: $mess_content ... En www.whatifcities.com/$citymin/$tituloenviarurl' ><img src='$template_url/images/ticon.png' /></a><a title='tuenti' href='http://www.tuenti.com/share?url=$mess_perma' ><img src='$template_url/images/tuentiicon.png' /></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href='$mess_perma'>$comentario</a>  $mess_edit</div></div><div class='clearer'></div>
		
		<div class='mess-text'>$mess_content</div>
		$mess_cats
		$mess_tags
	    
	</div>
	<div class='clearer'></div>
";

} else {
$mess_out .= "
	<div class='mess'>
	    $mess_img
		<div class='mess-aut'><div style='float:left'><a href='$mess_author_link'>$mess_author</a> | $mess_date | <a href='$home/msgmap?coor=$coor&cat=$categoryID&pos=$positivonegativo&id=$post_ID'>Ver localización</a>  $videomuestra</div>$votacion <div class='socialmedia'> <a target='_blank' name='fb_share' title='facebook' type='button' href='http://www.facebook.com/share.php?u=$mess_perma'><img src='$template_url/images/ficon.png' /></a><a target='_blank' title='twitter' href='http://twitter.com/home/?status=Estoy leyendo: $mess_content ... En www.whatifcities.com/$citymin/$tituloenviarurl' ><img src='$template_url/images/ticon.png' /></a><a title='tuenti' href='http://www.tuenti.com/share?url=$mess_perma' ><img src='$template_url/images/tuentiicon.png' /></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href='$mess_perma'>$comentario</a>  $mess_edit</div></div><div class='clearer'></div>
		
		<div class='mess-text'>$mess_content</div>
		$mess_cats
		$mess_tags

	</div>
	<div class='clearer'></div>
";
}

if ( $count % 3 == 0 ) {
	$mess_out .= "</div><!-- end class unique -->";
}

endwhile;


if ( $count % 3 != 0 ) {
$mess_out .= "</div><!-- end class unique -->";
}

$mess_out .= "<div class='controlMess' id='rightControlMess'  title='". __('Paso siguiente','whatif') . "'>&raquo;</div></div></div></div><!-- end ids dosificadores -->";

echo $mess_out;

else:
endif;
wp_reset_query();

?>
