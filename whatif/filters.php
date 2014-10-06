<?php
	// the categories filter
	$pn_options = array(
		array(
			'name' => 'positivo',
			'title' => __('Mensajes positivos','whatif'),
			'img' => 'pl-mini.png'
		),
		array(
			'name' => 'negativo',
			'title' => __('Mensajes negativos','whatif'),
			'img' => 'mn-mini.png'
		)
	);

	$perma = $perma_pn = $perma_filtro = get_permalink(). "?";

	$filter_out = "<ul class='filter-cats'>";
	$filter_out .= "
		<li id='tax-reset' class='filter-cat'>
			<a title='" . __('Restablecer','whatif') . "' href='" .$perma. "'><img src='" .WHATIF_BLOGTHEME. "/images/reset.png' style='width:30px;' alt='" . __('Restablecer','whatif') . "' /></a>
			<div class='filter-tit'><a href=''></a></div>
		</li>
	";

	foreach ( $pn_options as $option ) {
		$perma_pn = $perma;
		if ( $option['name'] == $pn ) { $pn_class = " class='active'"; $perma_pn .= ""; }
		else { $perma_pn .= "pn=" .$option['name']. "&"; $pn_class = ""; }
		if ( $filtro != '' ) { $perma_pn .= "filtro=" .$filtro. "&"; }
		$perma_pn = substr($perma_pn, 0, -1);

		$filter_out .= "<li id='tax-" .$option['name']. "' class='filter-cat'>
			<a" .$pn_class. " title='" .$option['title']. "' href='" .$perma_pn. "'><img src='" .WHATIF_BLOGTHEME. "/images/" .$option['img']. "' alt='" .$option['title']. "' /></a></li>
		";
	}

	foreach ( get_categories() as $categ ) {
		$cat_id = $categ->term_id;
		$perma_filtro = $perma;
		if ( $cat_id == $filtro ) { $filter_class = " class='active'"; $perma_filtro .= ""; }
		else { $perma_filtro .= "filtro=" .$cat_id. "&"; $filter_class = ""; }
		if ( $pn != '' ) { $perma_filtro .= "pn=" .$pn. "&"; }
		$perma_filtro = substr($perma_filtro, 0, -1);

		$cat_perma = get_category_link($categ->term_id);
		$cat_meta = get_option( "taxonomy_$cat_id" );
		$cat_img = $cat_meta['image'];
		if ( function_exists('get_cat_icon') ) {
		// compatibility with old versions of whatif
			$categImg = get_cat_icon("cat=$cat_id&echo=false&link=false&small=true");
		} elseif ( $cat_img != '' ) {
			$categImg = "<img src='" .$cat_img. "' alt='" .$categ->name. "' />";
		} else { $categImg = $categ->name; }
		
		$filter_out .= "
			<li id='$categ->slug' class='filter-cat'>
				<div>
				<a" .$filter_class. " href='" .$perma_filtro. "'>$categImg</a>
				</div>
				<div class='filter-tit'>$categ->category_count</div>
			</li>
		";
		
	}
	$filter_out .= "</ul><!-- end class mess-cats -->";

	echo $filter_out;
?>
