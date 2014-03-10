<?php

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<meta content="Ecosistema Urbano" name="author" />
<meta content="<?php _e('Herramienta de participación urbana','whatif'); ?>" name="description" />
<meta content="urbanismo, ecosistema urbano" name="keywords" />
<meta content="Ecosistema Urbano" name="organization" />
<meta content="Madrid, España" name="Locality" />
<meta http-equiv="content-language" content="es" />

<link rel="stylesheet" type="text/css" href="http://code.google.com/css/dev_docs.css">


<script type="text/javascript">
function limita(elEvento, maximoCaracteres) {
  var elemento = document.getElementById("cajadescripcion");

  // Obtener la tecla pulsada 
  var evento = elEvento || window.event;
  var codigoCaracter = evento.charCode || evento.keyCode;
  // Permitir utilizar las teclas con flecha horizontal
  if(codigoCaracter == 37 || codigoCaracter == 39) {
    return true;
  }

  // Permitir borrar con la tecla Backspace y con la tecla Supr.
  if(codigoCaracter == 8 || codigoCaracter == 46) {
    return true;
  }
  else if(elemento.value.length >= maximoCaracteres ) {
    return false;
  }
  else {
    return true;
  }
}

function actualizaInfo(maximoCaracteres) {
  var elemento = document.getElementById("cajadescripcion");
  var info = document.getElementById("info");

  if(elemento.value.length >= maximoCaracteres ) {
    info.innerHTML = "Maximo "+maximoCaracteres+" caracteres";
  }
  else {
    info.innerHTML = "Puedes escribir hasta "+(maximoCaracteres-elemento.value.length)+" caracteres adicionales";
  }
}

</script>

<?php include "general-vars.php"; ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php if ( is_page("mensajes") || is_page("imagenes") || is_author() || is_single() || is_page("msgmap")) { ?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo("template_directory"); echo "/css/jquery.lightbox-0.5.css" ?>" media="screen" />
<?php } ?>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed suscription" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed suscription" href="<?php bloginfo('atom_url'); ?>" /> 
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>

<script src="<?php bloginfo('template_url'); echo "/js/jquery.js"; ?>" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>	


<?php $positivonegativo = $_GET['valor'];
if ( is_page("formulario") && $positivonegativo == 'positivo' ) { ?>
<script src="<?php bloginfo('template_url'); echo "/js/deslizanteForm.js"; ?>" type="text/javascript"></script>
<script type="text/javascript">
<?php foreach ( get_categories("exclude=1&hide_empty=0") as $categ ) { ?>
$(document).ready(function(){
	$('#<?php echo "$categ->slug" ?>').bind('click', function(){
	 if ( $(this).hasClass('<?php echo "$color_pl" ?>') ) {
		$(this).children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/$categ->slug.png"; ?>');

		$(this).removeClass('<?php echo "$color_pl" ?>');
		$("#valorcategory").val('');
	
	 } else {
		$(this).children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/a-$categ->slug.png"; ?>');
		$(this).addClass('<?php echo "$color_pl" ?>');
		$("#valorcategory").val('<?php echo $categ->cat_ID ?>');
		
	}
	
			var currentId = $(this).attr('id');
		
		if (currentId == 'arquitectura-urbanismo')
		{
		$("#comunidad-ciudadana").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/comunidad-ciudadana.png"; ?>');
		$("#espacio-publico-medioambiente").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/espacio-publico-medioambiente.png"; ?>');
		$("#movilidad").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/movilidad.png"; ?>');
		$("#otros").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/otros.png"; ?>');
		$("#comunidad-ciudadana").removeClass('<?php echo "$color_pl" ?>');
		$("#espacio-publico-medioambiente").removeClass('<?php echo "$color_pl" ?>');
		$("#movilidad").removeClass('<?php echo "$color_pl" ?>');
		$("#otros").removeClass('<?php echo "$color_pl" ?>');
		}
		if (currentId == 'comunidad-ciudadana')
		{
		$("#arquitectura-urbanismo").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/arquitectura-urbanismo.png"; ?>');
		$("#espacio-publico-medioambiente").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/espacio-publico-medioambiente.png"; ?>');
		$("#movilidad").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/movilidad.png"; ?>');
		$("#otros").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/otros.png"; ?>');
		$("#arquitectura-urbanismo").removeClass('<?php echo "$color_pl" ?>');
		$("#espacio-publico-medioambiente").removeClass('<?php echo "$color_pl" ?>');
		$("#movilidad").removeClass('<?php echo "$color_pl" ?>');
		$("#otros").removeClass('<?php echo "$color_pl" ?>');
		}
		if (currentId == 'espacio-publico-medioambiente')
		{
		$("#comunidad-ciudadana").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/comunidad-ciudadana.png"; ?>');
		$("#arquitectura-urbanismo").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/arquitectura-urbanismo.png"; ?>');
		$("#movilidad").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/movilidad.png"; ?>');
		$("#otros").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/otros.png"; ?>');
		$("#comunidad-ciudadana").removeClass('<?php echo "$color_pl" ?>');
		$("#arquitectura-urbanismo").removeClass('<?php echo "$color_pl" ?>');
		$("#movilidad").removeClass('<?php echo "$color_pl" ?>');
		$("#otros").removeClass('<?php echo "$color_pl" ?>');
		}
		if (currentId == 'movilidad')
		{
		$("#comunidad-ciudadana").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/comunidad-ciudadana.png"; ?>');
		$("#espacio-publico-medioambiente").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/espacio-publico-medioambiente.png"; ?>');
		$("#arquitectura-urbanismo").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/arquitectura-urbanismo.png"; ?>');
		$("#otros").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/otros.png"; ?>');
		$("#comunidad-ciudadana").removeClass('<?php echo "$color_pl" ?>');
		$("#espacio-publico-medioambiente").removeClass('<?php echo "$color_pl" ?>');
		$("#arquitectura-urbanismo").removeClass('<?php echo "$color_pl" ?>');
		$("#otros").removeClass('<?php echo "$color_pl" ?>');
		}
		if (currentId == 'otros')
		{
		$("#comunidad-ciudadana").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/comunidad-ciudadana.png"; ?>');
		$("#espacio-publico-medioambiente").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/espacio-publico-medioambiente.png"; ?>');
		$("#movilidad").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/movilidad.png"; ?>');
		$("#arquitectura-urbanismo").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/arquitectura-urbanismo.png"; ?>');
		$("#comunidad-ciudadana").removeClass('<?php echo "$color_pl" ?>');
		$("#espacio-publico-medioambiente").removeClass('<?php echo "$color_pl" ?>');
		$("#movilidad").removeClass('<?php echo "$color_pl" ?>');
		$("#arquitectura-urbanismo").removeClass('<?php echo "$color_pl" ?>');
		}		
		
	   

	
	});
});
<?php } ?>
</script>

<?php } elseif ( is_page("formulario") && $positivonegativo == 'negativo' ) { ?>
<script src="<?php bloginfo('template_url'); echo "/js/deslizanteForm.js"; ?>" type="text/javascript"></script>
<script type="text/javascript">
<?php foreach ( get_categories("exclude=1&hide_empty=0") as $categ ) { ?>
$(document).ready(function(){
	$('#<?php echo "$categ->slug" ?>').bind('click', function(){
	 if ( $(this).hasClass('<?php echo "$color_mn" ?>') ) {
		$(this).children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/$categ->slug.png"; ?>');
		$(this).removeClass('<?php echo "$color_mn" ?>');
		$("#valorcategory").val('');
	 } else {
		$(this).children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/r-$categ->slug.png"; ?>');
		$(this).addClass('<?php echo "$color_mn" ?>');
		$("#valorcategory").val('<?php echo $categ->cat_ID ?>');
	}
			var currentId = $(this).attr('id');
		
		if (currentId == 'arquitectura-urbanismo')
		{
		$("#comunidad-ciudadana").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/comunidad-ciudadana.png"; ?>');
		$("#espacio-publico-medioambiente").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/espacio-publico-medioambiente.png"; ?>');
		$("#movilidad").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/movilidad.png"; ?>');
		$("#otros").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/otros.png"; ?>');
		$("#comunidad-ciudadana").removeClass('<?php echo "$color_mn" ?>');
		$("#espacio-publico-medioambiente").removeClass('<?php echo "$color_mn" ?>');
		$("#movilidad").removeClass('<?php echo "$color_mn" ?>');
		$("#otros").removeClass('<?php echo "$color_mn" ?>');
		}
		if (currentId == 'comunidad-ciudadana')
		{
		$("#arquitectura-urbanismo").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/arquitectura-urbanismo.png"; ?>');
		$("#espacio-publico-medioambiente").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/espacio-publico-medioambiente.png"; ?>');
		$("#movilidad").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/movilidad.png"; ?>');
		$("#otros").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/otros.png"; ?>');
		$("#arquitectura-urbanismo").removeClass('<?php echo "$color_mn" ?>');
		$("#espacio-publico-medioambiente").removeClass('<?php echo "$color_mn" ?>');
		$("#movilidad").removeClass('<?php echo "$color_mn" ?>');
		$("#otros").removeClass('<?php echo "$color_mn" ?>');
		}
		if (currentId == 'espacio-publico-medioambiente')
		{
		$("#comunidad-ciudadana").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/comunidad-ciudadana.png"; ?>');
		$("#arquitectura-urbanismo").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/arquitectura-urbanismo.png"; ?>');
		$("#movilidad").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/movilidad.png"; ?>');
		$("#otros").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/otros.png"; ?>');
		$("#comunidad-ciudadana").removeClass('<?php echo "$color_mn" ?>');
		$("#arquitectura-urbanismo").removeClass('<?php echo "$color_mn" ?>');
		$("#movilidad").removeClass('<?php echo "$color_mn" ?>');
		$("#otros").removeClass('<?php echo "$color_mn" ?>');
		}
		if (currentId == 'movilidad')
		{
		$("#comunidad-ciudadana").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/comunidad-ciudadana.png"; ?>');
		$("#espacio-publico-medioambiente").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/espacio-publico-medioambiente.png"; ?>');
		$("#arquitectura-urbanismo").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/arquitectura-urbanismo.png"; ?>');
		$("#otros").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/otros.png"; ?>');
		$("#comunidad-ciudadana").removeClass('<?php echo "$color_mn" ?>');
		$("#espacio-publico-medioambiente").removeClass('<?php echo "$color_mn" ?>');
		$("#arquitectura-urbanismo").removeClass('<?php echo "$color_mn" ?>');
		$("#otros").removeClass('<?php echo "$color_mn" ?>');
		}
		if (currentId == 'otros')
		{
		$("#comunidad-ciudadana").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/comunidad-ciudadana.png"; ?>');
		$("#espacio-publico-medioambiente").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/espacio-publico-medioambiente.png"; ?>');
		$("#movilidad").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/movilidad.png"; ?>');
		$("#arquitectura-urbanismo").children('img').attr('src','<?php bloginfo('template_directory'); echo "/images/arquitectura-urbanismo.png"; ?>');
		$("#comunidad-ciudadana").removeClass('<?php echo "$color_mn" ?>');
		$("#espacio-publico-medioambiente").removeClass('<?php echo "$color_mn" ?>');
		$("#movilidad").removeClass('<?php echo "$color_mn" ?>');
		$("#arquitectura-urbanismo").removeClass('<?php echo "$color_mn" ?>');
		}		
	});
});
<?php } ?>
</script>
<?php } elseif ( is_author() || is_page("mensajes") || is_page("imagenes") ) { ?>
<script src="<?php bloginfo('template_url'); echo "/js/deslizanteMess.js"; ?>" type="text/javascript"></script>
<?php } ?>
<?php if ( is_page("mensajes") || is_page("imagenes") || is_author() || is_single() || is_page("msgmap") ) { ?>
	<script type="text/javascript" src="<?php bloginfo("template_directory"); echo "/js/jquery.lightbox-0.5.js" ?>"></script>
	<script type="text/javascript">
		$(function() {
		//$('a[@rel*=lightbox]').lightBox(); // Select all links that contains lightbox rel
		$('.mosac-img a').lightBox();
		$('.mess-img a').lightBox();
		});
	</script>
	

	
<?php } ?>

<?php// $xajax->printJavascript("/xajax/"); //linea que ejecuta el ajax ?>  	


<?php  if ( is_page('msgmap') ) { ?>

<?php

$coor=$_GET['coor'];
$cat=$_GET['cat'];
$pos=$_GET['pos'];
$ID=$_GET['ID'];
$id=$_GET['id'];


	// the image
	$args = array( 'post_type' => 'attachment', 'numberposts' => 1, 'post_status' => null, 'post_parent' => $ID ); 
	$attachments = get_posts($args);

	if ( $attachments ) {


		foreach ( $attachments as $attachment ) {

	    $img_link=  wp_get_attachment_url( $ID );
	    
		    $imagenLink = wp_get_attachment_link($attachment->ID, 'thumbnail');	

  $imagenLink = str_replace("\"","'",$imagenLink);



}

}

query_posts( 'p=$id' );



if ( have_posts() ) :
       while ( have_posts() ) : the_post();


$post_ID = get_the_ID();

	//$mess_author = get_the_author(); // the author
	$mess_author_link = "$home/author/$mess_author"; // the author page link
	$mess_date = get_the_time('j\.n\.Y'); // the date
	$mess_content = get_the_content(); // the message
	$mess_perma = get_permalink(); // permanent link
	$mess_edit_link = get_edit_post_link(); // access to edit panel for this post
	$mess_author = get_the_author();
	$positivonegativo = get_post_meta($post->ID, "positivonegativo", true);
    $video = get_post_meta($post->ID, "video", $single = true);
    $comentario = "Comentario ".$post_ID;
    $comentario = "Permalink";
    
    
	    	// the tags
	$terms_pl = wp_get_post_terms( $post->ID, 'positivo' );
	$terms_mn = wp_get_post_terms( $post->ID, 'negativo' );
		$mess_tags = "<ul class='mess-tags'>";
	foreach ( $terms_pl as $term_pl ) {
		$term_link_pl = get_term_link("$term_pl->slug", 'positivo');
		$mess_tags .= "<li class='bg-p'><a href='$term_link_pl'>$term_pl->name</a></li>";
	}
	foreach ( $terms_mn as $term_mn ) {
		$term_link_mn = get_term_link("$term_mn->slug", 'negativo');
		$mess_tags .= "<li class='bg-c'><a href='$term_link_mn'>$term_mn->name</a></li>";
	}
		$mess_tags .= "</ul>";    
    


       endwhile;
else:
endif;
wp_reset_query();


$img=""; 


if ($pos =="positivo")
{
  if ($cat=="2") {$img="a2-arquitectura-urbanismo.png";}
  if ($cat=="3") {$img="a2-comunidad-ciudadana.png";}
  if ($cat=="4") {$img="a2-espacio-publico-medioambiente.png";}
  if ($cat=="5") {$img="a2-movilidad.png";}
  if ($cat=="6") {$img="a2-otros.png";}

}
if ($pos=="negativo")
{
  if ($cat=="2") {$img="r2-arquitectura-urbanismo.png";}
  if ($cat=="3") {$img="r2-comunidad-ciudadana.png";}
  if ($cat=="4") {$img="r2-espacio-publico-medioambiente.png";}
  if ($cat=="5") {$img="r2-movilidad.png";}
  if ($cat=="6") {$img="r2-otros.png";}
}

$perma = "otro";

 	$lascoordenadas .="
        
        
        
        var point".$perma." = new GLatLng(".$coor.");
var marker".$perma." = new GMarker(point".$perma.",miicono);
GEvent.addListener(marker".$perma.", \"click\", function() {
var myHtml".$perma." = \"<div class='mapmsg' >".$imagenLink."</div> <p style='text-align: left; padding-left:90px; font-size:12px;'>Enviado por: <strong>".$mess_author."</strong><br /><br /><a href=".$mess_perma.">".$mess_content."</a><br /><br />".$mess_categoria."<br /><br /></p><div class='clearer'></div><div class='tagsmap'>".$mess_tags."</div>    \";
map2.openInfoWindowHtml(point".$perma.", myHtml".$perma."); });
map2.addOverlay(marker".$perma.");
        
        
 ";
        
      
 
?> 


<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo $apigooglemaps ?>" type="text/javascript"></script>



   <script type="text/javascript">
    //<![CDATA[

    function load() {
      if (GBrowserIsCompatible()) {
      
   
    var miicono = new GIcon(G_DEFAULT_ICON);
    miicono.image = "<?php echo $template_url ?>/images/<?php echo $img; ?>";
    var tamanoIconomiicono = new GSize(40,40);
    miicono.iconSize = tamanoIconomiicono; 
    miicono.shadow = "<?php echo $template_url ?>/images/<?php echo $img; ?>";
    var tamanoSombramiicono = new GSize( 40,40);
    miicono.shadowSize = tamanoSombramiicono; 
    miicono.iconAnchor = new GPoint(20, 20);    

       
       
       var map2 = new GMap2(document.getElementById("map"));
map2.setCenter(new GLatLng(<?php echo $coor; ?>), <?php echo $zoomindividual; ?>);

map2.setUIToDefault();



<?php echo $lascoordenadas; ?>
        
      }
    }

    //]]>
    </script>
    
<style type="text/css">
.mess-tags li {    
    float: right !important;
    margin-bottom: 5px !important;
    padding: 0 5px !important;
}
.mess-tags {
 
    position: relative !important;
   
}    
.mapmsg a img
{
display:block;
float:left;'
}
</style>    

</head>
<body onload="load()" onunload="GUnload()">



<!--<div id="map" align="center" style="width: 940px; height: 460px"></div> -->

<?php } 

  elseif ( is_page('vistas') ) { ?>

<style type="text/css">
#epi
{
 top:160px;
}
.tit
{
height:1px !important;
}

</style>


</head>


<?php } 


  elseif ( is_page('mensajes') ) { ?>

<style type="text/css">
#epi
{
 top:-3px;
}
.filter-cats
{
top:60px;
}

</style>


</head>


<?php }  

 elseif ( is_single() ) { ?>

<style type="text/css">
#epi
{
 top:89px;
}

</style>


</head>


<?php }

 elseif ( is_author() ) { ?>

<style type="text/css">
#epi
{
 top:70px;
}

</style>


</head>


<?php } 

  elseif ( is_page('presentacion-consulta') || is_page('presentacion-participa')) { ?>

<style type="text/css">
#central
{
 margin-bottom:-60px;
}
.unique
{
top:20px;
}
#controll, #controlr {
    top: 140px;
}
</style>


</head>


<?php }  

  elseif ( is_page('entrada-formulario') ) { ?>

<style type="text/css">
#central
{
 margin-bottom:-100px;
}
</style>


</head>


<?php }  

  elseif ( is_page('imagenes') ) { ?>

<style type="text/css">

#epi
{
 top:0;
}
.mosac
{
margin-bottom:-53px;
}
</style>


</head>


<?php }  

  elseif ( is_page('palabras-clave') ) { ?>

<style type="text/css">
#central
{
 margin-bottom:-20px;
}
</style>


</head>


<?php } 

 elseif ( is_home() ) { ?>

<style type="text/css">

.epi-menu
{
left:0;
}
</style>


</head>


<?php }  



  elseif ( is_page('localizaciones') ) { ?>


<style type="text/css">
#epi
{
 top:0;
}
.mosac
{
margin-bottom:-53px;
}
</style>

<?php

$filtro=$_GET['filtro'];
$pn=$_GET['pn'];
$pn2="";
$pn2=$_GET['pn2'];


if($pn=="positivo"){$textoposinega= " - " . __('Positivo','whatif');}
if($pn=="negativo"){$textoposinega=" - " . __('Negativo','whatif');}
if($filtro=="2"){$textoextra=" - " . __('Arquitectura urbanismo','whatif');}
if($filtro=="3"){$textoextra=" - " . __('Comunidad ciudadana','whatif');}
if($filtro=="4"){$textoextra=" - " . __('Espacio público medioambiente','whatif');}
if($filtro=="5"){$textoextra=" - " . __('Movilidad','whatif');}
if($filtro=="6"){$textoextra=" - " . __('Otros','whatif');}


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




    //aadir una marca en Obanos con el icono amarillo
   // var obanos = new GLatLng(42.67991150445874,-1.7859649658203125);
   // var marker = new GMarker(obanos, iconoAmarillo);
   // map.addOverlay(marker);

query_posts( "meta_key=coordenadas&posts_per_page=-1&$valor=$valor_query&cat=$filtro" );


if ( have_posts() ) :
       while ( have_posts() ) : the_post();
       $post_id = get_the_ID();
       
       
       
       $coord = get_post_meta($post->ID, "coordenadas", $single = true);
       
       
       	$mess_author = get_the_author(); // the author
    	$mess_author_link = "$home/author/$mess_author"; // the author page link
	    $mess_date = get_the_time('j\.n\.Y'); // the date
	    $mess_content = get_the_content(); // the message
	    $mess_perma = get_permalink(); // permanent link
	    $mess_edit_link = get_edit_post_link(); // access to edit panel for this post
	
	    $coor = get_post_meta($post->ID, "coordenadas", true);
	    
	    $positivonegativo = get_post_meta($post->ID, "positivonegativo", true);
	    
	    	foreach ( get_the_category() as $categ ) {
		$categoryID = $categ->term_id;
		
		}

	    if ($categoryID=="2" AND $positivonegativo=="positivo"){$categoryID="arquitecturaicono";}
	    if ($categoryID=="3" AND $positivonegativo=="positivo"){$categoryID="comunidadicono";}
	    if ($categoryID=="4" AND $positivonegativo=="positivo"){$categoryID="publicoicono";}
	    if ($categoryID=="5" AND $positivonegativo=="positivo"){$categoryID="movilidadicono";}
	    if ($categoryID=="6" AND $positivonegativo=="positivo"){$categoryID="otrosicono";}
	    if ($categoryID=="1" AND $positivonegativo=="positivo"){$categoryID="otrosicono";}

	    if ($categoryID=="2" AND $positivonegativo=="negativo"){$categoryID="arquitecturaiconor";}
	    if ($categoryID=="3" AND $positivonegativo=="negativo"){$categoryID="comunidadiconor";}
	    if ($categoryID=="4" AND $positivonegativo=="negativo"){$categoryID="publicoiconor";}
	    if ($categoryID=="5" AND $positivonegativo=="negativo"){$categoryID="movilidadiconor";}
	    if ($categoryID=="6" AND $positivonegativo=="negativo"){$categoryID="otrosiconor";}
	    if ($categoryID=="1" AND $positivonegativo=="negativo"){$categoryID="otrosiconor";}	

	    
	    	// the tags
	$terms_pl = wp_get_post_terms( $post->ID, 'positivo' );
	$terms_mn = wp_get_post_terms( $post->ID, 'negativo' );
		$mess_tags = "<ul class='mess-tags'>";
	foreach ( $terms_pl as $term_pl ) {
		$term_link_pl = get_term_link("$term_pl->slug", 'positivo');
		$mess_tags .= "<li class='bg-p'><a href='$term_link_pl'>$term_pl->name</a></li>";
	}
	foreach ( $terms_mn as $term_mn ) {
		$term_link_mn = get_term_link("$term_mn->slug", 'negativo');
		$mess_tags .= "<li class='bg-c'><a href='$term_link_mn'>$term_mn->name</a></li>";
	}
		$mess_tags .= "</ul>";
	 	$mess_content = trim( preg_replace( '/\s+/', ' ', $mess_content ) );
	 	$mess_content = str_replace('"',"'",$mess_content);
	    
       
       
       	$lascoordenadas .="
        
        
        var point".$post_id." = new GLatLng(".$coord.");
var marker".$post_id." = new GMarker(point".$post_id.", ".$categoryID.");
GEvent.addListener(marker".$post_id.", \"click\", function() {

var myHtml".$post_id." = \"<div class='mapmsg' ><img alt='' src='$template_url/images/default.png' style='display:block;float:left;'/></div><p style='width:500px;text-align: left; padding-left:90px; font-size:12px;'>" . __('Enviado por:','whatif') . " <strong>".$mess_author."</strong><br /><br /><a href=".$mess_perma.">".$mess_content."</a><br /><br />".$mess_categoria."<br /><br /></p><div class='clearer'></div><div class='tagsmap'>".$mess_tags."</div>\";
map2.openInfoWindowHtml(point".$post_id.", myHtml".$post_id."); });
map2.addOverlay(marker".$post_id.");
        
        
        
        ";
        
      
//echo $lascoordenadas."<br /><br /><br /><br />";       
       
       endwhile;
else:
endif;
wp_reset_query();



?> 




<script type="text/javascript"
      src="http://maps.google.com/maps?file=api&amp;&v=2.75&geo?q=<?php echo $city; ?>&gl=es&sensor=true&key=<?php echo $apigooglemaps ?>"></script>


   <script type="text/javascript">
    //<![CDATA[

    function load() {
      if (GBrowserIsCompatible()) {

    //iconos para las marcas

    
    var movilidadicono = new GIcon( G_DEFAULT_ICON);
    movilidadicono.image = "<?php echo $template_url ?>/images/a2-movilidad.png";
    var tamanoIconomovilidad = new GSize(40,40);
    movilidadicono.iconSize = tamanoIconomovilidad; 
    movilidadicono.shadow = "<?php echo $template_url ?>/images/a2-movilidad.png";
    var tamanoSombramovilidad = new GSize( 40,40);
    movilidadicono.shadowSize = tamanoSombramovilidad; 
    movilidadicono.iconAnchor = new GPoint(20,20);
    movilidadicono.imageMap = [0,0, 39,0, 39,39, 0,39];


    var comunidadicono = new GIcon(G_DEFAULT_ICON);
    comunidadicono.image = "<?php echo $template_url ?>/images/a2-comunidad-ciudadana.png";
    var tamanoIconocomunidad = new GSize(40,40);
    comunidadicono.iconSize = tamanoIconocomunidad; 
    comunidadicono.shadow = "<?php echo $template_url ?>/images/a2-comunidad-ciudadana.png";
    var tamanoSombracomunidad = new GSize( 40,40);
    comunidadicono.shadowSize = tamanoSombracomunidad; 
    comunidadicono.iconAnchor = new GPoint(20,20);
    comunidadicono.imageMap = [0,0, 39,0, 39,39, 0,39];
    
    var publicoicono = new GIcon(G_DEFAULT_ICON);
    publicoicono.image = "<?php echo $template_url ?>/images/a2-espacio-publico-medioambiente.png";
    var tamanoIconopublico = new GSize(40,40);
    publicoicono.iconSize = tamanoIconopublico; 
    publicoicono.shadow = "<?php echo $template_url ?>/images/a2-espacio-publico-medioambiente.png";
    var tamanoSombrapublico = new GSize( 40,40);
    publicoicono.shadowSize = tamanoSombrapublico; 
    publicoicono.iconAnchor = new GPoint(20,20);
    publicoicono.imageMap = [0,0, 39,0, 39,39, 0,39];
    
    var arquitecturaicono = new GIcon(G_DEFAULT_ICON);
    arquitecturaicono.image = "<?php echo $template_url ?>/images/a2-arquitectura-urbanismo.png";
    var tamanoIconoarquitectura = new GSize(40,40);
    arquitecturaicono.iconSize = tamanoIconoarquitectura; 
    arquitecturaicono.shadow = "<?php echo $template_url ?>/images/a2-arquitectura-urbanismo.png";
    var tamanoSombraarquitectura = new GSize( 40,40);
    arquitecturaicono.shadowSize = tamanoSombraarquitectura; 
    arquitecturaicono.iconAnchor = new GPoint(20,20);
    arquitecturaicono.imageMap = [0,0, 39,0, 39,39, 0,39];
    
    var otrosicono = new GIcon(G_DEFAULT_ICON);
    otrosicono.image = "<?php echo $template_url ?>/images/a2-otros.png";
    var tamanoIconootros = new GSize(40,40);
    otrosicono.iconSize = tamanoIconootros; 
    otrosicono.shadow = "<?php echo $template_url ?>/images/a2-otros.png";
    var tamanoSombraotros = new GSize( 40,40);
    otrosicono.shadowSize = tamanoSombraotros; 
    otrosicono.iconAnchor = new GPoint(20,20);  
    otrosicono.imageMap = [0,0, 39,0, 39,39, 0,39];
  
    var movilidadiconor = new GIcon( G_DEFAULT_ICON);
    movilidadiconor.image = "<?php echo $template_url ?>/images/r2-movilidad.png";
    var tamanoIconomovilidadr = new GSize(40,40);
    movilidadiconor.iconSize = tamanoIconomovilidadr; 
    movilidadiconor.shadow = "<?php echo $template_url ?>/images/r2-movilidad.png";
    var tamanoSombramovilidadr = new GSize( 40,40);
    movilidadiconor.shadowSize = tamanoSombramovilidadr; 
    movilidadiconor.iconAnchor = new GPoint(20,20);
    movilidadiconor.imageMap = [0,0, 39,0, 39,39, 0,39];

    var comunidadiconor = new GIcon(G_DEFAULT_ICON);
    comunidadiconor.image = "<?php echo $template_url ?>/images/r2-comunidad-ciudadana.png";
    var tamanoIconocomunidadr = new GSize(40,40);
    comunidadiconor.iconSize = tamanoIconocomunidadr; 
    comunidadiconor.shadow = "<?php echo $template_url ?>/images/r2-comunidad-ciudadana.png";
    var tamanoSombracomunidadr = new GSize( 40,40);
    comunidadiconor.shadowSize = tamanoSombracomunidadr; 
    comunidadiconor.iconAnchor = new GPoint(20,20);
    comunidadiconor.imageMap = [0,0, 39,0, 39,39, 0,39];
    
    var publicoiconor = new GIcon(G_DEFAULT_ICON);
    publicoiconor.image = "<?php echo $template_url ?>/images/r2-espacio-publico-medioambiente.png";
    var tamanoIconopublicor = new GSize(40,40);
    publicoiconor.iconSize = tamanoIconopublicor; 
    publicoiconor.shadow = "<?php echo $template_url ?>/images/r2-espacio-publico-medioambiente.png";
    var tamanoSombrapublicor = new GSize( 40,40);
    publicoiconor.shadowSize = tamanoSombrapublicor; 
    publicoiconor.iconAnchor = new GPoint(20,20);
    publicoiconor.imageMap = [0,0, 39,0, 39,39, 0,39];
    
    var arquitecturaiconor = new GIcon(G_DEFAULT_ICON);
    arquitecturaiconor.image = "<?php echo $template_url ?>/images/r2-arquitectura-urbanismo.png";
    var tamanoIconoarquitecturar = new GSize(40,40);
    arquitecturaiconor.iconSize = tamanoIconoarquitecturar; 
    arquitecturaiconor.shadow = "<?php echo $template_url ?>/images/r2-arquitectura-urbanismo.png";
    var tamanoSombraarquitecturar = new GSize( 40,40);
    arquitecturaiconor.shadowSize = tamanoSombraarquitecturar; 
    arquitecturaiconor.iconAnchor = new GPoint(20,20);
    arquitecturaiconor.imageMap = [0,0, 39,0, 39,39, 0,39];
    
    var otrosiconor = new GIcon(G_DEFAULT_ICON);
    otrosiconor.image = "<?php echo $template_url ?>/images/r2-otros.png";
    var tamanoIconootrosr = new GSize(40,40);
    otrosiconor.iconSize = tamanoIconootrosr; 
    otrosiconor.shadow = "<?php echo $template_url ?>/images/r2-otros.png";
    var tamanoSombraotrosr = new GSize( 40,40);
    otrosiconor.shadowSize = tamanoSombraotrosr; 
    otrosiconor.iconAnchor = new GPoint(20,20); 
    otrosiconor.imageMap = [0,0, 39,0, 39,39, 0,39];
    
    
       
     
       
       var map2 = new GMap2(document.getElementById("map"));
map2.setCenter(new GLatLng(<?php echo $coordenadasmapa ?>), <?php echo $zoomtodas ?>);
map2.setUIToDefault();

// Aqui las coordenadas
<?php echo $lascoordenadas; ?>
        
      }
    }

    //]]>
    </script>

<style type="text/css">
.mess-tags li {    
    float: right !important;
    margin-bottom: 5px !important;
    padding: 0 5px !important;
}
.mess-tags {
 
    position: relative !important;

}    
.mapmsg a img
{
display:block;
float:left;'
}
.tagsmap{position:relative;top:-5px;left:-10px;}
</style> 

</head>
<body onload="load()" onunload="GUnload()">


<?php } 





 elseif ( is_page('formulario') ) { ?>
 
 <style type="text/css">
#epi
{
 top:270px;
}

#dosificadorForm #deslizanteForm 
{
left:-23px;
position:relative;
}
.cat-selector 
{
left:-15px;
}
</style>

<?php $positivonegativo = $_GET["valor"]; 


if ($positivonegativo == "positivo") {$posneg = $bg_pl;}

elseif ($positivonegativo == "negativo") {$posneg = $bg_mn;}



?>

<script type="text/javascript">

function contadores(valor)
{

   var contador = document.getElementById('escondido').value;
   
   if (contador == "0") contador=0;
   if (contador == "1") contador=1;
   if (contador == "2") contador=2;
   if (contador == "3") contador=3;
   if (contador == "4") contador=4;
   if (contador == "5") contador=5;

   if (valor == "sumar") 
   {
     contador = contador+1;
     document.getElementById('escondido').setAttribute('value', contador);
   }
   
   if (valor == "restar") 
   {
     contador = contador-1;
     document.getElementById('escondido').setAttribute('value', contador);
   }   


}

function vaciaterm(valor1, id)
{



document.getElementById(valor1).style.display='none';


	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var string_length = 4;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	

document.getElementById(valor1).setAttribute('id', randomstring);



 var contenedorCaja = document.participaform.cajaterm.value;
 
 valor1 = valor1+",";
 
contenedorCaja=  contenedorCaja.replace(valor1,"");

document.participaform.cajaterm.value = contenedorCaja;

document.getElementById(id).className='colorB';

contadores('restar');

}


function llenarterm(valor1, valorcaja, colorclass, id)
{

  var contador = document.getElementById('escondido').value;
  
  if (contador < 5)

  {
 valor2=valor1;
 valor1 = valor1+",";
 
 
 
document.participaform.cajaterm.value = valorcaja  +valor1;

 var contenedorE = document.getElementById('contEtiquetas').innerHTML;
 
  document.getElementById('contEtiquetas').innerHTML = contenedorE + "<span class='<?php echo $posneg ?> ' id='"+valor2+"'>"+valor2+"<a onclick=\"vaciaterm('"+valor2+"','"+id+"'); \">X</a></span>";

 document.getElementById(id).className =colorclass;
 
 contadores('sumar');
 }

}



function llenarinput(escondido)
{

	document.participaform.escondido.value =  'si'; 
	//var objeto = getElementById(escondido);
	//objeto.value ='si';
}



</script>



<script type="text/javascript"
      src="http://maps.google.com/maps?file=api&amp;&v=2.75&geo?q=<?php echo $city; ?>&gl=es&sensor=true&key=<?php echo $apigooglemaps ?>"></script>

<script type="text/javascript">

//<![CDATA[

var map;
var mapKey;
var marker;
var KEY_RE = /^([a-zA-Z0-9\-\_=]{86})|(internal.*)$/

/* *
* Utility function to extract parameters appended to URL.
* @param {String} name Name of parameter in URL
* @return {String} Value of parameter, or "" if not found
*/
function getURLParam(name) {
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.href);
  return (results == null ? "" : results[1]);
}

/**
* Function to create URL-friendly version of parameters.
* @return {String} String of concatenated parameters
*/
function getParamsURL(){
  var paramsURL = "";
  
  paramsURL += "&addressTEXT=" + document.getElementById("addressTEXT").value;
  var infoWindowTEXT = document.getElementById("infoWindowTEXT").value;
  infoWindowTEXT = infoWindowTEXT.replace("<","&lt;");
  infoWindowTEXT = infoWindowTEXT.replace(">","&gt;");
  paramsURL += "&infoWindowTEXT=" + escape(infoWindowTEXT);
  paramsURL += "&infoWindowCHECKBOX=" + document.getElementById("infoWindowCHECKBOX").checked;
  paramsURL += "&mapWidthTEXT=" + document.getElementById("mapWidthTEXT").value;
  paramsURL += "&mapHeightTEXT=" + document.getElementById("mapHeightTEXT").value;
  paramsURL += "&mapControlCHECKBOX=" + document.getElementById("mapControlCHECKBOX").checked;
  paramsURL += "&mapTypeControlCHECKBOX=" + document.getElementById("mapTypeControlCHECKBOX").checked;
  paramsURL += "&mapZoom=" + map.getZoom();
  paramsURL += "&mapType=" + document.getElementById("mapTypeSELECT").selectedIndex;
  //paramsURL += "&geo?q=madrid";
 // paramsURL += "&gl=es";
 // paramsURL += "&sensor=false";

  if(marker != null) {
    paramsURL += "&markerPointLat=" + marker.getPoint().lat() + "&markerPointLng=" + marker.getPoint().lng(); 
  }
 
  return paramsURL;
}

function generateKey() {
  var siteUrl = document.getElementById("siteURL").value;
  var targetPage = "http://www.google.com/maps/api_key";
  var landingPage = "http://gmaps-samples.googlecode.com/svn/trunk/" +
                    "simplewizard/makemap.html" + "?generated=1" +
                    getParamsURL();

  var redirPage = targetPage + "?q=" + encodeURIComponent(landingPage) + 
                  "&client=google-maps";
  top.location = redirPage + "&url=" + encodeURIComponent(siteUrl);
}


function getKeyFromParams() {

  if (getURLParam('key')) {
    passedKey = getURLParam('key');
    if (passedKey.match(KEY_RE)) {
      return passedKey;
    }
  }
  return "";
}

function populateForm() {
  mapKey = getKeyFromParams();

  var presetAddressTEXT = getURLParam("addressTEXT");
  var presetInfoWindowTEXT = getURLParam("infoWindowTEXT");
  var presetSiteURL = getURLParam("url");
 
  if (presetSiteURL != "") {
    document.getElementById("siteURL").value = presetSiteURL;  
    document.getElementById("generatedCodeDIV").style.display = "block";
  }
  if(presetAddressTEXT != "") {
    document.getElementById("addressTEXT").value = unescape(presetAddressTEXT);
  } 
  if(presetInfoWindowTEXT != "") {
    presetInfoWindowTEXT = unescape(presetInfoWindowTEXT);
    presetInfoWindowTEXT = presetInfoWindowTEXT.replace("&lt;","<");
    presetInfoWindowTEXT = presetInfoWindowTEXT.replace("&gt;",">");
    document.getElementById("infoWindowTEXT").value = presetInfoWindowTEXT;
  } 

  var infoWindowCHECKBOX = getURLParam("infoWindowCHECKBOX");
  if(infoWindowCHECKBOX == "false") {
    document.getElementById("infoWindowCHECKBOX").checked = false;
  }

  var mapControlCHECKBOX = getURLParam("mapControlCHECKBOX");
  if(mapControlCHECKBOX == "false") {
    document.getElementById("mapControlCHECKBOX").checked = false;
  }

  var mapTypeControlCHECKBOX = getURLParam("mapTypeControlCHECKBOX");
  if(mapTypeControlCHECKBOX == "false") {
    document.getElementById("mapTypeControlCHECKBOX").checked = false;
  }

  var mapWidthTEXT = getURLParam("mapWidthTEXT");
  if(mapWidthTEXT != "") {
    document.getElementById("mapWidthTEXT").value = mapWidthTEXT;
  }
  var mapHeightTEXT = getURLParam("mapHeightTEXT");
  if(mapHeightTEXT != "") {
    document.getElementById("mapHeightTEXT").value = mapHeightTEXT;
  }
  
  var markerPointLat = getURLParam("markerPointLat");
  var markerPointLng = getURLParam("markerPointLng");

  if(markerPointLat != "" && markerPointLng != "") {
    var point = new GLatLng(parseFloat(markerPointLat), parseFloat(markerPointLng));
    map.clearOverlays();
    map.setCenter(point, 13);
    marker = new GMarker(point, {draggable:true});
    GEvent.addListener(marker, 'click', function() {
      marker.openInfoWindow(document.getElementById("infoWindowTEXT").value);
    });
    GEvent.addListener(marker, 'dragend', function() {
      updateCode();
    });

    map.addOverlay(marker);
  }


  var mapZoom = getURLParam("mapZoom");
  if(mapZoom != "") {
    map.setZoom(parseInt(mapZoom));
  }

  var mapType = getURLParam("mapType");
  if(mapType != "") {
    document.getElementById("mapTypeSELECT").selectedIndex = parseInt(mapType);
  }
}

function updateCode() {
   document.getElementById("p_mapKey").innerHTML = mapKey;
   if(document.getElementById("mapControlCHECKBOX").checked) {
     document.getElementById("p_showMapControl").innerHTML = "map.addControl(new GSmallMapControl());";
   } else {
     document.getElementById("p_showMapControl").innerHTML = "";
   }

   if(document.getElementById("mapTypeControlCHECKBOX").checked) {
     document.getElementById("p_showMapTypeControl").innerHTML = "map.addControl(new GMapTypeControl());";
   } else {
     document.getElementById("p_showMapTypeControl").innerHTML = "";
   }


   var infoWindowTEXT = document.getElementById("infoWindowTEXT").value;
   if(infoWindowTEXT != "") {
     infoWindowTEXT = infoWindowTEXT.replace("<","&lt;");
     infoWindowTEXT = infoWindowTEXT.replace(">","&gt;");
     document.getElementById("p_infoWindowHTML").innerHTML = 'var html = "' + infoWindowTEXT + '";';
     document.getElementById("p_infoWindowEVENT").innerHTML = "GEvent.addListener(marker, 'click', function() { marker.openInfoWindowHtml(html); });"
     if(document.getElementById("infoWindowCHECKBOX").checked) {
       document.getElementById("p_showInfoWindow").innerHTML = "marker.openInfoWindowHtml(html);";
     } else {
       document.getElementById("p_showInfoWindow").innerHTML = "";
     }
   } else {
     document.getElementById("p_infoWindowHTML").innerHTML = '';
     document.getElementById("p_infoWindowEVENT").innerHTML = ""
     document.getElementById("p_showInfoWindow").innerHTML = "";
   }

   if(marker != null) {
     document.getElementById("p_markerPoint").innerHTML = marker.getPoint();
   }
   document.getElementById("p_mapZoom").innerHTML = map.getZoom();
   
  
   
   document.getElementById("p_mapWidth").innerHTML = document.getElementById("mapWidthTEXT").value;
   document.getElementById("p_mapHeight").innerHTML = document.getElementById("mapHeightTEXT").value;

   document.getElementById("p_mapType").innerHTML = document.getElementById("mapTypeSELECT").value;
}

function load() {
  if (GBrowserIsCompatible()) {
    map = new GMap2(document.getElementById("map"));
    map.setCenter(new GLatLng(<?php echo $coordenadasmapa; ?>), 13);

    
   // map._restricter = new TRestricter(map);
    
   map.setUIToDefault();
    
    map.addControl(new GMapTypeControl());


   
   // map._restricter.restrict(new GLatLng(40.19551923117092,-4.1143798828125), new GLatLng(40.63257553985803,-3.280792236328125));
    
    GEvent.addListener(map, "moveend", function(marker, point) {
    
  
      updateCode();
    });
    geocoder = new GClientGeocoder();
    populateForm();
    updateCode();
    showAddress();

  }
  

  
}

    /******  TRestricter  **********************************************/

    // Constructor
    TRestricter = function (map) {
        this.map = map;
    }
    // Función que activa la limitación del desplazamiento
    TRestricter.prototype.restrict = function (sw, ne) {
        this.map._allowedBounds = new GLatLngBounds(sw, ne);
        GEvent.addListener(this.map, 'move', this.checkBounds);
    }
    // Función que desactiva la limitación del desplazamiento
    TRestricter.prototype.unrestrict = function () {
        this.map._allowedBounds = null;
    }
    // Listener encargado de comprobar el desplazamiento
    TRestricter.prototype.checkBounds = function() {
            if (!this._allowedBounds || this._allowedBounds.contains(this.getCenter())) return;
        var x = Math.min(Math.max(this.getCenter().lng(), this._allowedBounds.getSouthWest().lng()), this._allowedBounds.getNorthEast().lng());
        var y = Math.min(Math.max(this.getCenter().lat(), this._allowedBounds.getSouthWest().lat()), this._allowedBounds.getNorthEast().lat());         
            this.setCenter(new GLatLng(y,x));
    }
    // Establece los límites de zoom del mapa
    TRestricter.prototype.zoomLevels = function (min, max) {
        var array = this.map.getMapTypes() || [];
        for (var i=0; i<array.length; i++) {
            array[i].getMinimumResolution = function () { return min };
                array[i].getMaximumResolution = function () { return max };
        }
    }



function showAddress() {
  var address = document.getElementById("addressTEXT").value;
  address = address + " España";
  if (geocoder) {
    geocoder.getLatLng(
      address,
      function(point) {
        if (!point) {
          alert(address + " not found");
        } else {
          map.clearOverlays();
          map.setCenter(point, <?php echo $zoomformulario ?>);
          document.participaform.ll.value = point.lat() + "," + point.lng();
          
          marker = new GMarker(point, {draggable:false});
	  GEvent.addListener(marker, 'click', function() {
            marker.openInfoWindow(document.getElementById("infoWindowTEXT").value);
            
       
          
          }); 
          

          
	  GEvent.addListener(marker, 'dragend', function() {
            updateCode();
          });
          map.addOverlay(marker);
        }
      }
    );
  }
  
  
  
  //aadir una marca en Madrid con icono por defecto y etiqueta
    function createMarker(point, icon, tag) {
      var marker = new GMarker(point, icon);
      GEvent.addListener(marker, "click", function() {
        marker.openInfoWindowHtml(tag);
      });
      return marker;
    }
    var aranguren = new GLatLng(<?php echo $coordenadasmapa; ?>);
    var tag = '<b>Mensaje</b>';
    var marker = createMarker(aranguren, "", tag);
    map.addOverlay(marker);


    function tratamiento_clic(overlay,point){
      if (point){
        marker.setPoint(point);
        document.participaform.ll.value = point.lat() + "," + point.lng();
        //alert ("Has hecho click!\n
        //  El punto donde has hecho click es: " + point.toString());
      }
    }
    GEvent.addListener(map, "click", tratamiento_clic);

  
}

 //]]>
</script>

<!-- script para deshabilitar enter en input-->
<script>
function pulsar(e) {
	tecla=(document.all) ? e.keyCode : e.which;
  if(tecla==13) return false;
}
</script>



<!-- Validador form jquery -->

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript">

        (function($){
          $.fn.validator = function(opts){
            $(this).find('.notFilled').live('keyup', function(){
              if($(this).val()!="" || $(this).val()!="Describe tu idea (140 caracteres como máximo)"){
                  $(this).removeClass('notFilled');
              }
            });
            return $(this).submit(function(evt){
              $(this).find('.required').each(function(){
                if ($(this).attr('value') == ''|| $(this).val()=="Describe tu idea (140 caracteres como máximo)"){
                
                // var valor = $("#escondido").attr('value'); 

                      
                      var opcion = $(this).attr("id");
                      
                      if (opcion == "cajaterm") opcion = "Palabras clave";
                      if (opcion == "valorcategory") opcion = "Categoria";
                      if (opcion == "cajadescripcion") opcion = "Descripcion";
                      


                  alert("Falta por rellenar el campo: "+opcion+".\n\nPor favor vuelva hacia atras para completarlo. \n\nGracias."); 

                  
                  
                  $(this).addClass('notFilled');
                  
                  evt.preventDefault();
                }
                
   
                
               
              });
                  
              
              $(this).find('.notFilled').first().focus();
              
  
              
            });

          };

           
          
        })(jQuery);

        jQuery(document).ready(function(){
          jQuery('form').validator();
     
        });
    </script>




</head>
<body onload="load()" onkeypress="return pulsar(event)" >

<?php } else { // if not map ?>





</head>


<?php } ?>

<div id="super">

<div id="central">

<div id="pre">

<?php
//	$fail = $_GET['fail'];
//	$perma = get_permalink();
//	if ( is_page_template("formulario.php") ) { $positivonegativo = $_GET["valor"]; $perma .= "?valor=$positivonegativo"; }
//if ( is_user_logged_in() ) {
//	$log_out = "
//	<div id='logout-form'>
//	<form action='$home/logout' method='post'>
//		<input type='hidden' name='ref' value='".$perma."' />
//		<input class='logout-boton' type='submit' value='Abandonar sesión' name='logout' />
//	</form>
//	</div>
//	";
////} else {
////	$log_out ="
////	<div id='login-form'>
////	<form action='$home/login' method='post'>
////		<input class='login-caja' type='text' name='nombre' value='usuario' onblur=\"if(this.value == '') {this.value = 'usuario';}\" onfocus=\"if(this.value == 'usuario') {this.value = '';}\" />
////		<input class='login-caja' type='password' name='pass' value='contrase&ntilde;a' onblur=\"if(this.value == '') {this.value = 'contrase&ntilde;a';}\" onfocus=\"if(this.value == 'contrase&ntilde;a') {this.value = '';}\" />
////		<input class='login-check' type='checkbox' name='remember' value='true' />
////		<input type='hidden' name='ref' value='".$perma."' />
////		<input class='login-boton' type='submit' value='Iniciar sesión' name='login' />
////	</form>
////	</div>
////	";
//}
//	echo $log_out;
	?>
</div><!-- end id pre -->
<hr />
