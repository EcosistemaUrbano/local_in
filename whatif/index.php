<?php get_header();
include "general-vars.php";

$home_out = "
<div id='centro'>
	<div class='tercio terciol'>
		<a href='$home/presentacion-participa'>" . __('Participa','whatif') . "</a>
	</div>

	<div class='tercioc'>
		<img src='$template_url/images/home.png' alt='" . __('Inicio','whatif') . "' width='300px' />
	</div>

	<div class='tercio tercior'>
		<a href='$home/presentacion-consulta'>" . __('Consulta los resultados','whatif') . "</a>
	</div>
</div>
";
echo $home_out;

get_footer(); ?>
