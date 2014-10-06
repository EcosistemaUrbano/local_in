<?php ob_start();
/*
Template Name: Formulario
*/

get_header();

if ( array_key_exists('valor', $_GET) ) { $positivonegativo = sanitize_text_field( $_GET["valor"] ); } else { $positivonegativo = ""; }
if ( $positivonegativo == 'positivo' || $positivonegativo == '' ) {
	$bg = WHATIF_STYLE_POSITIVE_BG;
	$color = WHATIF_STYLE_POSITIVE_COLOR;
	$clasecolor='"'.WHATIF_STYLE_POSITIVE_COLOR.'"';
	$chover = WHATIF_STYLE_POSITIVE_HOVER;
	$tit_1 = __('Describe tu idea','whatif');
	$media_img_bg = "media-img-pl";
	$media_vid_bg = "media-vid-pl";

} elseif ( $positivonegativo == 'negativo' ) {
	$bg = WHATIF_STYLE_NEGATIVE_BG;
	$color = WHATIF_STYLE_NEGATIVE_COLOR;
	$clasecolor='"'.WHATIF_STYLE_NEGATIVE_COLOR.'"';
	$chover = WHATIF_STYLE_NEGATIVE_HOVER;
	$tit_1 = __('Describe tu problema','whatif');
	$media_img_bg = "media-img-mn";
	$media_vid_bg = "media-vid-mn";
	$clasetags = WHATIF_STYLE_NEGATIVE_COLOR;
}

if ( is_user_logged_in() ) { ?>

	<div id="dosificadorForm">
	<div id="deslizanteForm">

	<form id="participaform" name="participaform" method="post" action="<?php echo WHATIF_BLOGURL."/formulario-enviado" ?>" enctype="multipart/form-data">
	       
		<fieldset id="paso-1" class="deslizaForm">
			<div id="paso26" class="paso">2/6</div>
			<div class="tit">
				<h2><?php echo $tit_1 ?></h2>
			</div>
			<span id="info" class=<?php echo $clasecolor ?>></span>
			<textarea onkeypress="return limita(event, 140);" onkeyup="actualizaInfo(140)" name="contenido" cols="45" rows="2" class="required caja <?php echo $bg ?> textBox" class="required" id="cajadescripcion" onblur="if(this.value == '') {this.value = '<?php _e('Describe tu idea (140 caracteres como máximo)','whatif'); ?>';}" onfocus="if(this.value == '<?php _e('Describe tu idea (140 caracteres como máximo)','whatif'); ?>') {this.value = '';}"><?php _e('Describe tu idea (140 caracteres como máximo)','whatif'); ?></textarea>
		</fieldset>

		<fieldset id="paso-2" class="deslizaForm">
			<div id="paso36" class="paso">3/6</div>
			<div class="tit">
				<h2><?php _e('Elige una categoría','whatif'); ?></h2>
			</div>
			<?php // categories list with icon
			$cat_divs = "<div class='cat-selector' name='categoria'>";
			$cat_select = "<select id='valorcategory' name='valorcategory[]' multiple>";
		foreach ( get_categories("hide_empty=0") as $categ ) {
			$categoryID = $categ->term_id;
			//if ( $categoryID == $filtro ) { $filter_class = " class='active'"; }
			//else { $filter_class = ""; }
			$cat_meta = get_option( "taxonomy_$categoryID" );
			$cat_img = $cat_meta['image'];
			//$categLink = get_category_link($categ->term_id);
			//$categDesc = category_description($categ->term_id);
			if ( function_exists('get_cat_icon') ) {
				$categImg = get_cat_icon("cat=$categoryID&echo=false&link=false&small=false");
			} elseif ( $cat_img != '' ) {
				$categImg = "<img src='" .$cat_img. "' alt='" .$categ->name. "' />";
			} else { $categImg = ""; }
			
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
			<h2><?php _e('Elige palabras clave','whatif'); ?></h2>
			<span class="subtit"><?php _e('Hasta un máximo de 5','whatif'); ?></span>
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
		
		<span><?php _e('También puedes añadir tus propias palabras clave separadas por comas.','whatif'); ?></span>
		<input type="text" value="" name="cajaterm" class="required caja-negra caja-term textBox vanadium-valid" id="cajaterm" />
		
		<div id="contEtiquetas" name="contEtiquetas"></div>
		
	</fieldset>

	<fieldset id="paso-4" class="deslizaForm">
		<div id="paso56" class="paso">5/6</div>
		<div class="tit">
			<h2><?php _e('Elige una localización','whatif'); ?></h2>
		</div>

		<div id="map" style="width: 800px; height: 320px"></div>
		<input onfocus="if(this.value == '<?php echo WHATIF_LOCATION_ADDRESS; ?>') {this.value = '';}" onblur="if(this.value == '') {this.value = '<?php echo WHATIF_LOCATION_ADDRESS; ?>';}" class="caja-negra caja-map" type="text" size="60" id="addressTEXT" value="<?php echo WHATIF_LOCATION_ADDRESS; ?>" />
		<input class="boton-negro" type="button" value="<?php _e('Posicionar','whatif'); ?>" onclick="showAddress()"/>
		

<br clear="all" />

  <input style="display:none" type="text" size="50" id="infoWindowTEXT" value="" onkeyup="updateCode()" onkeypress="updateCode()" />

  <input style="display:none" type="checkbox" id="infoWindowCHECKBOX" CHECKED onclick="updateCode()" />

  <input style="display:none" type="checkbox" id="mapControlCHECKBOX" CHECKED onclick="updateCode()" />

  <input style="display:none" type="checkbox" id="mapTypeControlCHECKBOX" CHECKED onclick="updateCode()" />

  <input style="display:none" type="text" size="3" id="mapWidthTEXT" value="500" onkeyup="updateCode()" onkeypress="updateCode()" />

  <input style="display:none" type="text" size="3" id="mapHeightTEXT" value="300" onkeyup="updateCode()" onkeypress="updateCode()" />

  <select style="display:none" id="mapTypeSELECT" onchange="updateCode()">
   <option value="G_NORMAL_MAP" SELECTED><?php _e('Vista mapa','whatif');?></option>

   <option value="G_SATELLITE_MAP"><?php _e('Vista satélite','whatif');?></option>
   <option value="G_HYBRID_MAP"><?php _e('Vista híbrida','whatif');?></option>
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
			<h2><?php _e('Añade una foto o un vídeo','whatif'); ?></h2>
		</div>
		<div class="media-selector">
			<?php
			$perma = WHATIF_BLOGURL;
			// message uploader: text, category, tags, image
			$img_ins_out = "
			<div id='subirimagen' class='media-up $media_img_bg'>
    				<input type='hidden' name='MAX_FILE_SIZE' value='3000000' />
				<div id='upload'>
					<span class='media-feedback'>".__('Elige una imagen','whatif')."</span>
				</div><span id='media-boton' class='media-icon'>+</span>
				<input id='blas' class='media' type='file' name='blas' />
				
				<input type='hidden' name='ref' value='$perma' />
			</div>
			";
			$vid_ins_out = "
			<div id='subirvideo' class='media-up $media_vid_bg'>
				<input class='caja-negra media' type='text' name='urlvideo' value='http://'  />
				<label>" . __('Añadir un vídeo','whatif') . "</label>
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
			<p><?php _e('Si quieres modificar algo puedes volver hacia atrás pulsando sobre las fechas.','whatif'); ?></p>
			<p><?php _e('Para publicar pulsa a continuación:','whatif'); ?></p>
		</div>
         
         
		<input id="publicar" type="submit" name="" value="<?php _e('Publicar mensaje','whatif'); ?>" />
		<input id="escondido" type="hidden" name="escondido" value="0" />



	</fieldset>

</form>


</div><!-- end id deslizanteForm -->
</div><!-- end id dosificadorForm -->

<?php } else { // if user not login
	$ref = get_permalink(). "?valor=" .$positivonegativo;
	$redirect = WHATIF_BLOGURL. "/user-sesion?ref=" .esc_url($ref);
	wp_redirect($redirect);
	exit;
} // end if user is logged in ?>


<?php get_footer(); ob_end_flush(); ?>
