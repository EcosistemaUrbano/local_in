<?php
	// the categories filter
	$perma = get_permalink();
	if ( $pn == 'positivo' ) { $pl_class = " class='active'"; $mn_class = ""; }
	elseif ( $pn == 'negativo' ) { $mn_class = " class='active'"; $pl_class = ""; }
	else { $pl_class = $mn_class = ""; }
	$filter_out = "<ul class='filter-cats'>";
	$filter_out .= "
		<li id='tax-reset' class='filter-cat'>
			<a title='" . __('Restablecer','whatif') . "' href='" .$perma. "'><img src='" .WHATIF_BLOGTHEME. "/images/reset.png' style='width:30px;' alt='" . __('Restablecer','whatif') . "' /></a>
			<div class='filter-tit'><a href=''></a></div>
		</li>
			
		<li id='tax-positivo' class='filter-cat'>
			<a" .$pl_class. " title='" . __('Mensajes positivos','whatif') . "' href='" .$perma. "?pn=positivo'><img src='" .WHATIF_BLOGTHEME. "/images/pl-mini.png' alt='" . __('Mensajes positivos','whatif') . "' /></a>
		</li>
		<li id='tax-negativo' class='filter-cat'>
			<a" .$mn_class. " title='" . __('Mensajes negativos','whatif') . "' href='" .$perma. "?pn=negativo'><img src='" .WHATIF_BLOGTHEME. "/images/mn-mini.png' alt='" . __('Mensajes negativos','whatif') . "' /></a>
		</li>
	";
	foreach ( get_categories() as $categ ) {
		$cat_id = $categ->term_id;
		if ( $cat_id == $filtro ) { $filter_class = " class='active'"; }
		else { $filter_class = ""; }
		$cat_perma = get_category_link($categ->term_id);
		$cat_meta = get_option( "taxonomy_$cat_id" );
		$cat_img = $cat_meta['image'];
		if ( function_exists('get_cat_icon') ) {
		// compatibility with old versions of whatif
			$categImg = get_cat_icon("cat=$cat_id&echo=false&link=false&small=true");
		} elseif ( $cat_img != '' ) {
			$categImg = "<img src='" .$cat_img. "' alt='" .$categ->name. "' />";
		} else { $categImg = $categ->name; }
		
		$identificador = $categ->slug;
		$identificador = str_replace("-","",$identificador);
		
		$filter_out .= "
			<li id='$categ->slug' class='filter-cat'>
			<div>
			<a" .$filter_class. " href='" .$perma. "?filtro=$cat_id&pn=$pn2'>$categImg</a>
			</div>
			<div class='filter-tit'>$categ->category_count</div>
			</li>
		";
		
	}
	$filter_out .= "</ul><!-- end class mess-cats -->";

	echo $filter_out;
	
?>
