<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<meta content="<?php echo WHATIF_ORGANIZATION ?>" name="author" />
<meta content="<?php echo WHATIF_BLOGDESC ?>" name="description" />
<meta content="<?php echo WHATIF_KEYWORDS ?>" name="keywords" />
<meta content="<?php echo WHATIF_ORGANIZATION ?>" name="organization" />
<meta content="<?php echo WHATIF_LOCATION_CITY. ", " .WHATIF_LOCATION_COUNTRY; ?>" name="Locality" />

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed suscription" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed suscription" href="<?php bloginfo('atom_url'); ?>" /> 
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head();

// if map for single
if ( array_key_exists('vista', $_GET) ) { $view = sanitize_text_field($_GET['vista']); } else { $view = ""; }
if ( is_single() && $view == "map" ) {
	$id = get_the_ID();
	// the image
	$args = array( 'post_type' => 'attachment', 'numberposts' => 1, 'post_status' => null, 'post_parent' => $id ); 
	$attachments = get_posts($args);
	if ( $attachments ) {
		foreach ( $attachments as $attachment ) {
			$image_link = get_attachment_link($attachment->ID). "?ref=map";
			$alt_attachment = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
			$imageurl = wp_get_attachment_image_src( $attachment->ID, 'thumbnail');
			$mess_img = "<div class='messSingle-img'><a href='" .$image_link. "'><img src='" .$imageurl[0]. "' alt='" .$alt_attachment. "' ></a></div>";
		}
	} else {
		$img_url = WHATIF_BLOGTHEME. "/images/default.png";
		$mess_img = "<div class='messSingle-img'><img src='$img_url' alt='". __('No image','whatif') . "' /></div>";
	}

	$args = array(
		'p' => $id
	);
	$messages_in_map = get_posts($args);
	foreach ( $messages_in_map as $message ) {
		setup_postdata($message);
		$post_ID = $message->ID;
		$mess_author = get_the_author_meta( 'user_login', $message->post_author );
		$mess_author_link = get_author_posts_url( $message->post_author );
		$mess_date = get_the_date('j\.n\.Y',$post_ID);
		$mess_content = get_the_content();
		$mess_perma = get_permalink($post_ID);
		$mess_edit_link = get_edit_post_link($post_ID);
		$positivonegativo = get_post_meta($post_ID, "positivonegativo", true);
		$coor = get_post_meta($post_ID, "coordenadas", true);
		$video = get_post_meta($post_ID, "video", true);
		$comentario = __('Permalink','whatif');
		$videomuestra="<a target='_blank' href='$video'>". __('View link','whatif') . "</a> | ";
	  	if($video=="" OR $video=="http://"){
	        	$videomuestra="";
		};
	if ( is_user_logged_in() ) { $mess_edit = " | <a href='$mess_edit_link'>". __('Edit','whatif') . "</a>"; }
	else { $mess_edit = ""; }

		if ( $positivonegativo == 'positivo' ) { $bg_class = 'bg-p'; $map_icon = "icon-pos"; }
		elseif ( $positivonegativo == 'negativo' ) { $bg_class = 'bg-c'; $map_icon = "icon-neg"; }

	// the categories
	$cats = wp_get_post_terms( $post_ID, 'category' );
	$mess_cats = "<ul class='messSingle-cats'>";
	$cat_count = 0;
	foreach ( $cats as $categ ) {
		$categoryID = $categ->term_id;
		$categLink = get_term_link($categ);
		$mess_cats .= "<li id='" .$categ->slug. "' class='messSingle-cat'><div class='mess-cat-tit'><a href='" .WHATIF_BLOGURL. "/vistas/mensajes?filtro=" .$categoryID. "'>" .$categ->name. "</a></div></li>";
		if ( $cat_count == 0 ) {
		// map marker
			$cat_meta = get_option("taxonomy_$categoryID");
			if ( is_array($cat_meta) && array_key_exists($map_icon,$cat_meta) && $cat_meta[$map_icon] != '' ) {
				$map_marker_url = $cat_meta[$map_icon];
			} else { $map_marker_url = WHATIF_BLOGTHEME. "/images/default-map-" .$map_icon. ".png"; }
		}
		$cat_count++;
	}
	$mess_cats .= "</ul><!-- end class mess-cats -->";

		// the tags
		$terms = wp_get_post_terms( $post_ID, $positivonegativo );
		$mess_tags = "<ul class='messSingle-tags'>";
		foreach ( $terms as $term ) {
			$term_link = get_term_link($term);
			$mess_tags .= "<li class='" .$bg_class. "'><a href='" .$term_link. "'>" .$term->name. "</a></li>";
		}
		$mess_tags .= "</ul>";    
	}
	wp_reset_postdata();

 	$lascoordenadas = "
var point = new GLatLng(".$coor.");
var marker = new GMarker(point,miicono);
GEvent.addListener(marker, \"click\", function() {
var myHtml = \"".$mess_img. "<div class='messSingle-aut'><div class='messSingle-meta'><a href='$mess_author_link'>$mess_author</a> | $mess_date | $videomuestra</div> <div class='messSingle-extra'><a href='$mess_perma'>$comentario</a>$mess_edit</div></div><div class='messSingle-text'>$mess_content</div><div class='messSingle-context'>".$mess_cats.$mess_tags."</div></div>\";	
map2.openInfoWindowHtml(point, myHtml); });
map2.addOverlay(marker);
	";
?> 
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo WHATIF_GOOGLE_KEY ?>" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[
function load() {
	if (GBrowserIsCompatible()) {
		var miicono = new GIcon(G_DEFAULT_ICON);
		miicono.image = "<?php echo $map_marker_url ?>";
		var tamanoIconomiicono = new GSize(40,40);
		miicono.iconSize = tamanoIconomiicono; 
		miicono.shadow = "<?php echo $map_marker_url; ?>";
		var tamanoSombramiicono = new GSize( 40,40);
		miicono.shadowSize = tamanoSombramiicono;
		miicono.iconAnchor = new GPoint(20, 20);

		var map2 = new GMap2(document.getElementById("map"));
		map2.setCenter(new GLatLng(<?php echo $coor; ?>), <?php echo WHATIF_MAP_ZOOM_SINGLE; ?>);

		map2.setUIToDefault();

		<?php echo $lascoordenadas; ?>
	}
}
//]]>
</script>
</head>
<body <?php body_class(); ?> onload="load()" onunload="GUnload()">

<?php } // Map view
elseif ( is_page_template('map.php') ) {

if ( array_key_exists('filtro', $_GET) ) { $filtro = sanitize_text_field( $_GET['filtro'] ); } else { $filtro = ""; }
if ( array_key_exists('pn', $_GET) ) { $pn = sanitize_text_field( $_GET['pn'] ); } else { $pn = ""; }

$plvaria = "pl-mini.png";
$mnvaria = "mn-mini.png";

$valor = $pn;
$valor_query = "";
$valor_terms = get_terms($valor);
$count2 = 0;
foreach ( $valor_terms as $term ) {
	$count2++;
	if ( $count2 == 1) { $valor_query .= "$term->slug"; }
	else { $valor_query .= ",$term->slug"; }
}

	$args = array(
		'meta_key' => 'coordenadas',
		'posts_per_page' => '-1',
		$valor => $valor_query,
		'cat' => $filtro
	);

	// BEGIN loop
	$messages_in_map = get_posts($args);
	if ( $messages_in_map >= 1 ) {
	$lascoordenadas = "";
	foreach ( $messages_in_map as $message ) {
		setup_postdata($message);
		$post_ID = $message->ID;
	    $coor = get_post_meta($post_ID, "coordenadas", true);
		$mess_author = get_the_author_meta( 'user_login', $message->post_author );
		$mess_author_link = get_author_posts_url( $message->post_author );
		$mess_date = get_the_date('j\.n\.Y',$post_ID);
		$mess_content = get_the_content();
		$mess_perma = get_permalink($post_ID);
		$mess_edit_link = get_edit_post_link($post_ID);
		$positivonegativo = get_post_meta($post_ID, "positivonegativo", true);
		$video = get_post_meta($post_ID, "video", true);
		$comentario = __('Permalink','whatif');
		$videomuestra="<a target='_blank' href='$video'>". __('View link','whatif') . "</a> | ";
	  	if($video=="" OR $video=="http://"){
	        	$videomuestra="";
		};
	if ( is_user_logged_in() ) { $mess_edit = " | <a href='$mess_edit_link'>". __('Edit','whatif') . "</a>"; }
	else { $mess_edit = ""; }

		if ( $positivonegativo == 'positivo' ) { $bg_class = 'bg-p'; $map_icon = "icon-pos"; $map_icon_slug = "pos"; }
		elseif ( $positivonegativo == 'negativo' ) { $bg_class = 'bg-c'; $map_icon = "icon-neg"; $map_icon_slug = "neg"; }

	// the categories
	$cats = wp_get_post_terms( $post_ID, 'category' );
	$mess_cats = "<ul class='messSingle-cats'>";
	$cat_count = 0;
	foreach ( $cats as $categ ) {
		$categoryID = $categ->term_id;
		$categLink = get_term_link($categ);
		$mess_cats .= "<li id='" .$categ->slug. "' class='messSingle-cat'><div class='mess-cat-tit'><a href='" .WHATIF_BLOGURL. "/vistas/mensajes?filtro=" .$categoryID. "'>" .$categ->name. "</a></div></li>";
		if ( $cat_count == 0 ) {
		// map marker
			$cat_meta = get_option("taxonomy_$categoryID");
			if ( is_array($cat_meta) && array_key_exists($map_icon,$cat_meta) && $cat_meta[$map_icon] != '' ) {
				$map_marker_url = $cat_meta[$map_icon];
			} else { $map_marker_url = WHATIF_BLOGTHEME. "/images/default-map-" .$map_icon. ".png"; }
		}
		$cat_count++;
	}
	$mess_cats .= "</ul><!-- end class mess-cats -->";

		// the tags
		$terms = wp_get_post_terms( $post_ID, $positivonegativo );
		$mess_tags = "<ul class='messSingle-tags'>";
		foreach ( $terms as $term ) {
			$term_link = get_term_link($term);
			$mess_tags .= "<li class='" .$bg_class. "'><a href='" .$term_link. "'>" .$term->name. "</a></li>";
		}
		$mess_tags .= "</ul>";    

	// the image
	$args = array( 'post_type' => 'attachment', 'numberposts' => 1, 'post_status' => null, 'post_parent' => $id ); 
	$attachments = get_posts($args);
	if ( $attachments ) {
		foreach ( $attachments as $attachment ) {
			$image_link = get_attachment_link($attachment->ID). "?ref=map";
			$alt_attachment = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
			$imageurl = wp_get_attachment_image_src( $attachment->ID, 'thumbnail');
			$mess_img = "<div class='messSingle-img'><a href='" .$image_link. "'><img src='" .$imageurl[0]. "' alt='" .$alt_attachment. "' ></a></div>";
		}
	} else {
		$img_url = WHATIF_BLOGTHEME. "/images/default.png";
		$mess_img = "<div class='messSingle-img'><img src='$img_url' alt='". __('No image','whatif') . "' /></div>";
	}

	if ( $filtro != '' ) { $map_cat_slug = $filtro; }
	else { $map_cat_slug = $categoryID; }
 	$lascoordenadas .= "
var point".$post_ID." = new GLatLng(".$coor.");
var marker".$post_ID." = new GMarker(point".$post_ID.", icon".$map_cat_slug.$map_icon_slug.");
GEvent.addListener(marker".$post_ID.", \"click\", function() {
var myHtml".$post_ID." = \"".$mess_img."<div class='messSingle-aut'><div class='messSingle-meta'><a href='$mess_author_link'>$mess_author</a> | $mess_date | $videomuestra</div> <div class='messSingle-extra'><a href='$mess_perma'>$comentario</a>$mess_edit</div></div><div class='messSingle-text'>$mess_content</div><div class='messSingle-context'>".$mess_cats.$mess_tags."</div></div>\";	
map2.openInfoWindowHtml(point".$post_ID.", myHtml".$post_ID."); });
map2.addOverlay(marker".$post_ID.");
        ";
       
	}
	} // end there are messages
	// END loop

	// markers
	$losmarkers = "var iconDefault = new GIcon(G_DEFAULT_ICON)";
	$all_cats = get_terms( 'category',array('fields'=>'ids') );
	foreach ( $all_cats as $cat ) {
		$cat_meta = get_option("taxonomy_$cat");
		foreach ( array('pos','neg') as $icon ) {
			if ( is_array($cat_meta) ) {
				if ( array_key_exists('icon-'.$icon,$cat_meta) && $cat_meta['icon-'.$icon] != '' ) {
					$map_marker_{$icon} = $cat_meta['icon-'.$icon];
				}
			} else { $map_marker_{$icon} = WHATIF_BLOGTHEME. "/images/default-map-" .$icon. ".png"; }

			$losmarkers .= "
			var icon".$cat.$icon." = new GIcon(G_DEFAULT_ICON);
			icon".$cat.$icon.".image = '".$map_marker_{$icon}."';
			var tamanoicon".$cat.$icon." = new GSize(40,40);
			icon".$cat.$icon.".iconSize = tamanoicon".$cat.$icon."; 
			icon".$cat.$icon.".iconAnchor = new GPoint(20,20);
			icon".$cat.$icon.".imageMap = [0,0, 39,0, 39,39, 0,39];
			";
		}
	}
?> 
<script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;&v=2.75&gl=es&sensor=true&key=<?php echo WHATIF_GOOGLE_KEY ?>"></script>
<script type="text/javascript">
//<![CDATA[
function load() {
	if (GBrowserIsCompatible()) {
		//iconos para las marcas
		<?php echo $losmarkers; ?>
    
		var map2 = new GMap2(document.getElementById("map"));
		map2.setCenter(new GLatLng(<?php echo WHATIF_MAP_COORDS ?>), <?php echo WHATIF_MAP_ZOOM ?>);
		map2.setUIToDefault();

		// Aqui las coordenadas
		<?php echo $lascoordenadas; ?>        
	}
}
//]]>
</script>
</head>
<body <?php body_class(); ?> onload="load()" onunload="GUnload()">

<?php } 
elseif ( is_page_template('formulario.php') ) {
 
if ( array_key_exists('valor', $_GET) ) { $positivonegativo = sanitize_text_field($_GET["valor"]); } else { $positivonegativo = ""; }

if ($positivonegativo == "positivo") {$posneg = WHATIF_STYLE_POSITIVE_BG;}
elseif ($positivonegativo == "negativo") {$posneg = WHATIF_STYLE_NEGATIVE_BG;}
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

<script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;&v=2.75&geo?q=<?php echo WHATIF_SEO_BLOGNAME; ?>&gl=es&sensor=true&key=<?php echo WHATIF_GOOGLE_KEY ?>"></script>
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
    map.setCenter(new GLatLng(<?php echo WHATIF_MAP_COORDS; ?>), 13);

    
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
  address = address + " <?php echo WHATIF_LOCATION_COUNTRY ?>";
  if (geocoder) {
    geocoder.getLatLng(
      address,
      function(point) {
        if (!point) {
          alert(address + " not found");
        } else {
          map.clearOverlays();
          map.setCenter(point, <?php echo WHATIF_MAP_ZOOM_FORM ?>);
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
    var aranguren = new GLatLng(<?php echo WHATIF_MAP_COORDS; ?>);
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
</head>
<body <?php body_class(); ?> onload="load()" onkeypress="return pulsar(event)" >

<?php } else { // if not map and not formulario ?>
</head>
<body <?php body_class(); ?>>

<?php } ?>

<div id="super">

<div id="central">
