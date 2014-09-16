<?php

/*
Template Name: Formulario-enviado-gracias
*/

get_header();

include "general-vars.php";



//Recojo datos
$variableUsuario = $user_ID;
$valorcategory = sanitize_text_field($_POST['valorcategory']);
$categorias = $valorcategory.",";

//Ahora convierto categorias en un array.
$elementoscat =explode(",", $categorias);

 $varvar1 = $elementoscat[0]; // trozo1
 $varvar2 = $elementoscat[1]; // trozo2 
 
  if ($varvar1=="") { $catfinal = "Uncategorized"; }
  if ($varvar1!="") { $cat2 .= $varvar1.","; }
  if ($varvar2!="") { $cat2 .= $varvar2.","; }
  
  $catfinal =explode(",", $cat2); //Creo un array para pasarlo así directamente a la funcion wp
 
$contenido= sanitize_text_field($_POST['contenido']);
$contenido = ereg_replace('"','', $contenido);

$titulo =  substr($contenido,0,20); // Pongo como titulo los 20 primeros caracteres del contenido

$tituloexplode =explode(" ", $titulo);

 $variable1 = $tituloexplode[0]; // trozo1
 $variable2 = $tituloexplode[1]; // trozo2 
 $variable3 = $tituloexplode[2]; // trozo3
 $variable4 = $tituloexplode[3]; // trozo4 
 $variable5 = $tituloexplode[4]; // trozo5
 $variable6 = $tituloexplode[5]; // trozo5
 $variable7 = $tituloexplode[6]; // trozo5 
 
if ( strlen($variable1) < 4 ) { $variable1="";  }
if ( strlen($variable2) < 4 ) { $variable2="";  }
if ( strlen($variable3) < 4 ) { $variable3="";  }
if ( strlen($variable4) < 4 ) { $variable4="";  }
if ( strlen($variable5) < 4 ) { $variable5="";  }
if ( strlen($variable6) < 4 ) { $variable6="";  }
if ( strlen($variable7) < 4 ) { $variable7="";  }

$titulo = $variable1." ".$variable2." ".$variable3." ".$variable4." ".$variable5." ".$variable6." ".$variable7;
 
$positivonegativo=$_POST['positivonegativo']; // que sera bien "positivo" o "negativo"
$tags=$_POST['cajaterm'];
$tags = ereg_replace(" ","", $tags);
//Separo por comas o veo como vienen los tags para dividir en 5 variables que es el maximo permitido de tags

//$tags = substr ($tags, 0, strlen($tags) - 1);//Quito el ultimo espacio para que no se converita en coma.

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
 
// Fin coger 5 terms

$coordenadas=$_POST['ll'];

$video= sanitize_text_field($_POST['urlvideo']);

$existemensaje="no";

while (have_posts()) : the_post(); 

    $mess_content = get_the_content(); // the message
    
    if ($mess_content == $contenido)
    {
     $existemensaje="si";
    }
    
endwhile;

rewind_posts();

if ($contenido !="" AND $catfinal !="" AND $tagsfinal !="" AND $existemensaje !="si")
{

// Hago los inserts

$post_id = wp_insert_post(array(
'post_type' => 'post', // "page" para páginas, "libro" para el custom post type libro...
'post_status' => 'publish', // "draft" para borrador, "future" para programarlo...
'post_author' => $variableUsuario, // el ID del autor, 1 para admin
'post_title' => $titulo,
'post_content' => $contenido, // el contenido
'post_category' => $catfinal // matriz de los ID de las categorías a las que asociar la entrada
)); // La funcion insert devuelve la id del post


add_post_meta($post_id, _liked, '0'); // Introduzco un valor para el sistema de votaciones


// asociamos a la entrada un campo personalizado para las coordenadas
add_post_meta($post_id, 'coordenadas', $coordenadas);
add_post_meta($post_id, 'video', $video);

// asociamos a la entrada un campo personalizado para ver si el comentario es positivo o negativo
add_post_meta($post_id, 'positivonegativo', $positivonegativo);




// Como ya tengo los tags y se si son negativos o positivos, los añado a su tabla 

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

} else {
	//echo "Problema al subir la imagen.";
	//echo 'Here is some more debugging info:';
	//print_r($_FILES);
}

$mensajesalida = __('Su mensaje se publicó correctamente','whatif');

} // Fin de insercion de datos 

else { $mensajesalida = __('Su mensaje no pudo ser publicado por algún error entre su conexión y el servidor, o bien ya existe un mensaje igual al que está intentando publicar. Por favor vuelva al formulario para reenviar su mensaje.','whatif'); }

$resultado = "Este es el cotenido:".$contenido."<br /><br />
               La categoria: ".$catfinal[0]."<br /><br />
               Si es positivo o negativo: ".$positivonegativo."<br /><br />
               Los tags: ".$tagsfinal[0].",".$tagsfinal[1].",".$tagsfinal[2].",".$tagsfinal[3].",".$tagsfinal[4]."<br /><br />
               Las coordenadas: ".$coordenadas."<br /><br />
               El video: ".$video
               ;

// to test potencial errors
// echo $resultado;
?>
   
  <p>

</p>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<p style="position:relative; left:150px; font-size:30px;" > <?php echo $mensajesalida ?></p> 
   
   
      <?php query_posts('showposts=1'); ?>
  

       <?php while (have_posts()) : the_post(); ?>

      <?php //$titulo = the_title(); ?>

<?php
$url = $home."/".$titulo;

//get_footer(); ?> 

<script type="text/javascript">

var pagina="<?php the_permalink(); ?>"
function redireccionar() 
{
location.href=pagina
} 
setTimeout ("redireccionar()", 10);

</script>

 <?php endwhile;?>
