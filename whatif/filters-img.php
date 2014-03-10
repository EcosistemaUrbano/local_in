<?php
	// the categories filter
	$perma = get_permalink();
	$filter_out = "<ul class='filter-cats'>";
		$filter_out .= "
		
			<li id='tax-reset' class='filter-cat'>
			
			<a title='" . __('Restablecer','whatif') . "'  href='$home/vistas/imagenes'><img src='$template_url/images/reset.png' style='width:30px;' alt='" . __('Restablecer','whatif') . "' /></a>
			<div class='filter-tit'><a href=''></a></div>
			</li>
			
			
			<li id='tax-positivo' class='filter-cat'>
			
			<a title='" . __('Mensajes positivos','whatif') . "' href='$home/vistas/imagenes?pn=positivo&pn2=$pn2'><img src='$template_url/images/$plvaria' alt='" . __('Mensajes positivos','whatif') . "' /></a>
			<div class='filter-tit'><a href=''></a></div>
			</li>
			<li id='tax-negativo' class='filter-cat ' >
			<a title='" . __('Mensajes negativos','whatif') . "' href='$home/vistas/imagenes?pn=negativo&pn2=$pn2'><img src='$template_url/images/$mnvaria' alt='" . __('Mensajes negativos','whatif') . "' /></a>
			<div class='filter-tit'><a href=''></a></div>
			</li>

		";
	foreach ( get_categories("exclude=1&hide_empty=0") as $categ ) {
		$categoryID = $categ->term_id;
		$categLink = get_category_link($categ->term_id);
		$permalink = "$perma?categ=$categ->slug";
		$slug= "$categ->slug";
		if ( function_exists('get_cat_icon') ) {
			$categImg = get_cat_icon("cat=$categoryID&echo=false&link=false&small=true");
		}
		
		$identificador = $categ->slug;
		$identificador = str_replace("-","",$identificador);
		
		$filter_out .= "
			<li id='$categ->slug' class='filter-cat'>
			<div class='$categ->slug' id='big$identificador' style='background-image:url(../../images/bigborder-$categ->slug); display:inline;'>
			<a href='$home/vistas/imagenes?filtro=$categoryID&pn=$pn2'>$categImg</a>
			</div>
			<div class='filter-tit'><a href='$home/vistas/imagenes?filtro=$categoryID&pn=$pn2'>$categ->category_count</a></div>
			</li>
		";
	}
	$filter_out .= "</ul><!-- end class mess-cats -->";

	echo $filter_out;
	
	
			if ($filtro =="2")
{
 ?>
 <script type="text/javascript">
 function cambiaImagen() {
  //document.getElementById("bigarquitecturaurbanismo").style.background='url(../imagenes/bigcircle.png)';
 // document.getElementById["bigarquitecturaurbanismo"].img.src = "../imagenes/bigcircle.png"; 
  document.getElementById('bigarquitecturaurbanismo').getElementsByTagName('img')[0].src= "<?php echo $template_url ?>/images/bigarquitectura.png";
    document.getElementById('bigarquitecturaurbanismo').getElementsByTagName('img')[0].width="40";
   document.getElementById('bigarquitecturaurbanismo').getElementsByTagName('img')[0].height="40";
  }
  cambiaImagen();
 </script>
 <?php
}
			if ($filtro =="3")
{
 ?>
 <script type="text/javascript">
 function cambiaImagen() {
  
  document.getElementById('bigcomunidadciudadana').getElementsByTagName('img')[0].src= "<?php echo $template_url ?>/images/bigcomunidad.png";
   document.getElementById('bigcomunidadciudadana').getElementsByTagName('img')[0].width="40";
   document.getElementById('bigcomunidadciudadana').getElementsByTagName('img')[0].height="40";  
  }
  cambiaImagen();
 </script>
 <?php
}
			if ($filtro =="4")
{
 ?>
 <script type="text/javascript">
 function cambiaImagen() {
 
  document.getElementById('bigespaciopublicomedioambiente').getElementsByTagName('img')[0].src= "<?php echo $template_url ?>/images/bigespaciopublico.png";
   document.getElementById('bigespaciopublicomedioambiente').getElementsByTagName('img')[0].width="40";
   document.getElementById('bigespaciopublicomedioambiente').getElementsByTagName('img')[0].height="40";  
  
  }
  cambiaImagen();
 </script>
 <?php
}
			if ($filtro =="5")
{
 ?>
 <script type="text/javascript">
 function cambiaImagen() {

   document.getElementById('bigmovilidad').getElementsByTagName('img')[0].src= "<?php echo $template_url ?>/images/bigmovilidad.png";
    document.getElementById('bigmovilidad').getElementsByTagName('img')[0].width="40";
   document.getElementById('bigmovilidad').getElementsByTagName('img')[0].height="40";  
  }
  cambiaImagen();
 </script>
 <?php
}
			if ($filtro =="6")
{
 ?>
 <script type="text/javascript">
 function cambiaImagen() {
  
  document.getElementById('bigotros').getElementsByTagName('img')[0].src= "<?php echo $template_url ?>/images/bigotros.png";
   document.getElementById('bigotros').getElementsByTagName('img')[0].width="40";
   document.getElementById('bigotros').getElementsByTagName('img')[0].height="40";  
  }
  cambiaImagen();
 </script>
 <?php
}
	
?>
