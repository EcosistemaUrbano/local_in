<?php ob_start();
/*
Template Name: Formulario
*/

get_header();

if ( array_key_exists('valor', $_GET) ) { $positivonegativo = sanitize_text_field( $_GET["valor"] ); } else { $positivonegativo = "positivo"; }
if ( $positivonegativo == 'positivo' ) {
	$bg = WHATIF_STYLE_POSITIVE_BG;
	$color = WHATIF_STYLE_POSITIVE_COLOR;
	$clasecolor='"'.WHATIF_STYLE_POSITIVE_COLOR.'"';
	$chover = WHATIF_STYLE_POSITIVE_HOVER;
	$tit_1 = __('Describe your idea','whatif');
	$media_img_bg = "media-img-pl";
	$media_vid_bg = "media-vid-pl";

} elseif ( $positivonegativo == 'negativo' ) {
	$bg = WHATIF_STYLE_NEGATIVE_BG;
	$color = WHATIF_STYLE_NEGATIVE_COLOR;
	$clasecolor='"'.WHATIF_STYLE_NEGATIVE_COLOR.'"';
	$chover = WHATIF_STYLE_NEGATIVE_HOVER;
	$tit_1 = __('Describe your problem','whatif');
	$media_img_bg = "media-img-mn";
	$media_vid_bg = "media-vid-mn";
	$clasetags = WHATIF_STYLE_NEGATIVE_COLOR;
}
$tit_extra = __('(maximum of 140 characters)','whatif');

if ( is_user_logged_in() ) {
// if user is logged in

	if ( !array_key_exists('positivonegativo',$_POST) ) {
	// if form hasn't been sent, then display form ?>

<div id="dosificadorForm">
<div id="deslizanteForm">
	<form id="participaform" name="participaform" method="post" action="<?php the_permalink(); ?>" enctype="multipart/form-data">
	       
		<fieldset id="paso-1" class="deslizaForm">
			<div id="paso26" class="paso">2/6</div>
			<div class="tit">
				<h2><?php echo $tit_1 ?></h2>
			</div>
			<span id="info" class=<?php echo $clasecolor ?>></span>
			<textarea onkeypress="return limita(event, 140);" onkeyup="actualizaInfo(140)" name="contenido" cols="45" rows="2" class="required caja <?php echo $bg ?> textBox" class="required" id="cajadescripcion" onblur="if(this.value == '') {this.value = '<?php echo $tit_1. " " .$tit_extra; ?>';}" onfocus="if(this.value == '<?php echo $tit_1. " " .$tit_extra; ?>') {this.value = '';}"><?php echo $tit_1. " " .$tit_extra; ?></textarea>
		</fieldset>

		<fieldset id="paso-2" class="deslizaForm">
			<div id="paso36" class="paso">3/6</div>
			<div class="tit">
				<h2><?php _e('Choose a category','whatif'); ?></h2>
			</div>
			<?php // categories list with icon
			$cat_divs = "<div class='cat-selector' name='categoria'>";
			$cat_select = "<select class='required' id='valorcategory' name='valorcategory[]' multiple>";
		foreach ( get_categories("hide_empty=0") as $categ ) {
			$categoryID = $categ->term_id;
			$cat_meta = get_option( "taxonomy_$categoryID" );
			$cat_img = $cat_meta['image'];
			if ( is_array($cat_meta) ) {
				if ( array_key_exists('image',$cat_meta) && $cat_meta['image'] != '' ) {
					$cat_img = $cat_meta['image'];
				}
			} else { $cat_img = WHATIF_BLOGTHEME. "/images/default-cat.png"; }
			$categImg = "<img src='" .$cat_img. "' alt='" .$categ->name. "' />";
			
			$idhidden = "hidden".$categ->slug;
			
			$cat_divs .= "
			<div id='$categoryID' class='cat-boton cat-img'>
				$categImg
				<div class='cat-tit'>$categ->name</div>
			</div>
			";
			$cat_select .= "<option value='$categoryID'>$categ->name</option>";
		}
		$cat_divs .= "</div><!-- end class cat-selector -->";
		$cat_select .= "</select>";
		echo $cat_divs . $cat_select; ?>
	</fieldset>

	<fieldset id="paso-3" class="deslizaForm">
		<div id="paso46" class="paso">4/6</div>
		<div class="tit">
			<h2><?php _e('Choose some tags','whatif'); ?></h2>
			<span class="subtit"><?php _e('Up to 5 keywords','whatif'); ?></span>
		</div>
		<?php
		$terms = $positivonegativo;
		$term_sel = "<ul class='term-selector $terms'>";
		foreach ( get_terms( "$terms", "number=20" , "hide_empty=0" ) as $term ) {
			$term_sel .= "<li><a  onclick='llenarterm(\"{$term->name}\", document.getElementById(\"participaform\").cajaterm.value, $clasecolor, $term->term_id)' id='$term->term_id' class='term-tit $chover' value='{$term->name}' >{$term->name}</a></li>";
		}
		$term_sel .= "</ul>";
		echo $term_sel;
		?>
		<span><?php _e('You can also add your own keywords, comma separated.','whatif'); ?></span>
		<input type="text" value="" name="cajaterm" class="required caja-negra caja-term textBox vanadium-valid" id="cajaterm" />
		<div id="contEtiquetas" name="contEtiquetas"></div>
	</fieldset>

	<fieldset id="paso-4" class="deslizaForm">
		<div id="paso56" class="paso">5/6</div>
		<div class="tit">
			<h2><?php _e('Choose a location','whatif'); ?></h2>
		</div>
		<div id="map" style="width: 800px; height: 320px"></div>
		<input onfocus="if(this.value == '<?php echo WHATIF_LOCATION_ADDRESS; ?>') {this.value = '';}" onblur="if(this.value == '') {this.value = '<?php echo WHATIF_LOCATION_ADDRESS; ?>';}" class="caja-negra caja-map" type="text" size="60" id="addressTEXT" value="<?php echo WHATIF_LOCATION_ADDRESS; ?>" />
		<input class="boton-negro" type="button" value="<?php _e('Reference','whatif'); ?>" onclick="showAddress()"/>

<br clear="all" />
  <input style="display:none" type="text" size="50" id="infoWindowTEXT" value="" onkeyup="updateCode()" onkeypress="updateCode()" />
  <input style="display:none" type="checkbox" id="infoWindowCHECKBOX" CHECKED onclick="updateCode()" />
  <input style="display:none" type="checkbox" id="mapControlCHECKBOX" CHECKED onclick="updateCode()" />
  <input style="display:none" type="checkbox" id="mapTypeControlCHECKBOX" CHECKED onclick="updateCode()" />
  <input style="display:none" type="text" size="3" id="mapWidthTEXT" value="500" onkeyup="updateCode()" onkeypress="updateCode()" />
  <input style="display:none" type="text" size="3" id="mapHeightTEXT" value="300" onkeyup="updateCode()" onkeypress="updateCode()" />
  <select style="display:none" id="mapTypeSELECT" onchange="updateCode()">
   <option value="G_NORMAL_MAP" SELECTED><?php _e('Map view','whatif');?></option>
   <option value="G_SATELLITE_MAP"><?php _e('Satellite view','whatif');?></option>
   <option value="G_HYBRID_MAP"><?php _e('Hybrid view','whatif');?></option>
  </select>

<br clear="all"/>
<div style="display:none" id="generatedCodeDIV" style="display:block">
<pre class="code" id="gHeadCode" style="width: 700px; overflow-x: scroll;">
&lt;!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"&gt;

&lt;html xmlns="http://www.w3.org/1999/xhtml"&gt;
  &lt;head&gt;
    &lt;meta http-equiv="content-type" content="text/html; charset=utf-8"/&gt;
    &lt;title&gt;Google Map&lt;/title&gt;
    &lt;script src="http://maps.google.com/maps?file=api&amp;v=2&key=<span id="p_mapKey"></span>"
            type="text/javascript"&gt;&lt;/script&gt;

    &lt;script type="text/javascript"&gt;
    //&lt;![CDATA[

    function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        
     
        
        
        var point = new GLatLng<span id="p_markerPoint"></span>;
        
          
   
        
        

   map.setCenter(point, <span id="p_mapZoom"></span>);  
        
  
        
   
        <span id="p_showMapControl"></span>
        <span id="p_showMapTypeControl"></span>
        map.setMapType(<span id="p_mapType"></span>);
        map.addControl(new GMapTypeControl());
        var marker = new GMarker(point);
        <span id="p_infoWindowHTML"></span>
        <span id="p_infoWindowEVENT"></span>

        map.addOverlay(marker);

        <span id="p_showInfoWindow"></span>
      }
    }

    //]]&gt;
    &lt;/script&gt;
  &lt;/head&gt;

  &lt;body onload="load()" onunload="GUnload()"&gt;

    &lt;div id="map" style="width: <span id="p_mapWidth"></span>px; height: <span id="p_mapHeight"></span>px"&gt;&lt;/div&gt;
  &lt;/body&gt;
&lt;/html&gt;

</pre>
</div>
	</fieldset>
	
	<fieldset id="paso-5" class="deslizaForm">
		<div id="paso66" class="paso">6/6</div>
		<div class="tit">
			<h2><?php _e('Add a photo or a video','whatif'); ?></h2>
		</div>
		<div class="media-selector">
			<?php
			$perma = WHATIF_BLOGURL;
			// message uploader: text, category, tags, image
			$img_ins_out = "
			<div id='subirimagen' class='media-up $media_img_bg'>
    				<input type='hidden' name='MAX_FILE_SIZE' value='3000000' />
				<div id='upload'>
					<span class='media-feedback'>".__('Choose an image','whatif')."</span>
				</div><span id='media-boton' class='media-icon'>+</span>
				<input id='blas' class='media' type='file' name='blas' />
				
				<input type='hidden' name='ref' value='$perma' />
			</div>
			";
			$vid_ins_out = "
			<div id='subirvideo' class='media-up $media_vid_bg'>
				<input class='caja-negra media' type='text' name='urlvideo' value='http://'  />
				<label>" . __('Add a video','whatif') . "</label>
			</div>
			";
			echo $img_ins_out;
			echo $vid_ins_out;
			?>		
	</fieldset>

	<fieldset id="paso-6" class="deslizaForm">
		<input type="hidden" name="positivonegativo" value="<?php echo $positivonegativo ?>"> 
		<input type="hidden" name="ll" value="" size="40" />
		<input type="hidden" name="zoom" value="" />
		<div id="finalform">
			<p><?php _e('If you want to modify something, you can go back using the black arrows.','whatif'); ?></p>
			<p><?php _e('To publish the message, click on the following button:','whatif'); ?></p>
		</div>
		<input id="publicar" type="submit" name="publicar" value="<?php _e('Publish message','whatif'); ?>" />
		<input id="escondido" type="hidden" name="escondido" value="0" />
	</fieldset>

</form>

</div><!-- end id deslizanteForm -->
</div><!-- end id dosificadorForm -->

	<?php } else {
	// if form has been sent, then do the inserts

		// author
		$variableUsuario = $user_ID;
		// categories
		foreach ( $_POST['valorcategory'] as $cat_selected ) {
			$cats[] = sanitize_text_field($cat_selected);
		}
		// content 
		$contenido= sanitize_text_field($_POST['contenido']);
		$contenido = str_replace('"','', $contenido);
		// title
		$author_name = get_the_author_meta('user_login',$user_ID);
		$time = current_time('mysql');
		$titulo = sprintf(__('Message sent by %s1 on %s2','whatif'),$author_name,$time);

		$positivonegativo = sanitize_text_field($_POST['positivonegativo']); // que sera bien "positivo" o "negativo"

		$tags = sanitize_text_field($_POST['cajaterm']);
		$tags = ereg_replace(" ","", $tags);
		//Separo por comas o veo como vienen los tags para dividir en 5 variables que es el maximo permitido de tags
		$elementos =explode(",", $tags);
		 $var1 = $elementos[0]; // trozo1
		 $var2 = $elementos[1]; // trozo2 
		 $var3 = $elementos[2]; // trozo3
		 $var4 = $elementos[3]; // trozo4 
		 $var5 = $elementos[4]; // trozo5
		  if ($var1=="") { $tagsfinal = "sin-tags"; }
		  if ($var1!="") { $tags2 .= $var1.","; }
		  if ($var2!="") { $tags2 .= $var2.","; }
		  if ($var3!="") { $tags2 .= $var3.","; }
		  if ($var4!="") { $tags2 .= $var4.","; }
		  if ($var5!="") { $tags2 .= $var5; }
		$tagsfinal =explode(",", $tags2); //Creo un array para pasarlo así directamente a la funcion wp

		$coordenadas= sanitize_text_field($_POST['ll']);
		$video= sanitize_text_field($_POST['urlvideo']);

		if ( $contenido !="" AND $cats !="" AND $tagsfinal !="" ) {
			$post_id = wp_insert_post(array(
				'post_type' => 'post', // "page" para páginas, "libro" para el custom post type libro...
				'post_status' => 'publish', // "draft" para borrador, "future" para programarlo...
				'post_author' => $variableUsuario, // el ID del autor, 1 para admin
				'post_title' => $titulo,
				'post_content' => $contenido, // el contenido
				'post_category' => $cats // matriz de los ID de las categorías a las que asociar la entrada
			),true); // La funcion insert devuelve la id del post

			add_post_meta($post_id, _liked, '0'); // Introduzco un valor para el sistema de votaciones

			// asociamos a la entrada un campo personalizado para las coordenadas
			add_post_meta($post_id, 'coordenadas', $coordenadas);
			add_post_meta($post_id, 'video', $video);
			// asociamos a la entrada un campo personalizado para ver si el comentario es positivo o negativo
			add_post_meta($post_id, 'positivonegativo', $positivonegativo);
			// asociamos la entrada a los términos que queramos de la taxonomía tags
			wp_set_post_terms( $post_id, $tagsfinal,$positivonegativo,'True');
			// image insert
			$upload_dir_var = wp_upload_dir();
			$upload_dir = $upload_dir_var['path']; // absolute path to uploads folder
			$filename = basename($_FILES['blas']['name']); // to get file name from form
			$filename = trim($filename); // removing spaces at the begining and end
			$filename = ereg_replace(" ", "-", $filename); // removing spaces inside the name

			$typefile = $_FILES['blas']['type']; // file type
			$uploaddir = realpath($upload_dir);
			$uploadfile = $uploaddir.'/'.$filename;

			$slugname = preg_replace('/\.[^.]+$/', '', basename($uploadfile));
			if ( file_exists($uploadfile) ) { // if file exists
				$count = "a";
				while ( file_exists($uploadfile) ) {
					$count++;
					if ( $typefile == 'image/jpeg' ) { $exten = 'jpg'; }
					elseif ( $typefile == 'image/png' ) { $exten = 'png'; }
					elseif ( $typefile == 'image/gif' ) { $exten = 'gif'; }
					$uploadfile = $uploaddir.'/'.$slugname.'-'.$count.'.'.$exten;
				}
			} // end if file exist

			if (move_uploaded_file($_FILES['blas']['tmp_name'], $uploadfile)) { // if the file is uploaded
				$slugname = preg_replace('/\.[^.]+$/', '', basename($uploadfile)); // defining image slug again to make it matching with file name
				$attachment = array(
					'post_mime_type' => $typefile,
					'post_title' => $slugname,
					'post_content' => '',
					'post_status' => 'inherit'
				);
				$attach_id = wp_insert_attachment( $attachment, $uploadfile, $post_id );
				// you must first include the image.php file
				// for the function wp_generate_attachment_metadata() to work
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				$attach_data = wp_generate_attachment_metadata( $attach_id, $uploadfile );
				wp_update_attachment_metadata( $attach_id,  $attach_data );
				$img_url = wp_get_attachment_url($attach_id);
			}

			// redirection
			$redirect = get_permalink($post_id)."?ref=form";
			wp_redirect($redirect);
			exit;
		} // end if all required fields are there

	} // end if form has been sent

} else { // if user not login
	$ref = get_permalink(). "?valor=" .$positivonegativo;
	$redirect = WHATIF_BLOGURL. "/user-sesion?ref=" .esc_url($ref);
	wp_redirect($redirect);
	exit;
} // end if user is logged in ?>


<?php get_footer(); ob_end_flush(); ?>
