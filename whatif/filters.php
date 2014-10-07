<?php
	// the categories filter
	$pn_options = array(
		array(
			'name' => 'positivo',
			'title' => __('Mensajes positivos','whatif'),
			'img' => 'default-pos.png'
		),
		array(
			'name' => 'negativo',
			'title' => __('Mensajes negativos','whatif'),
			'img' => 'default-neg.png'
		)
	);

	$perma = $perma_pn = $perma_filtro = get_permalink(). "?";

	$filter_out = "<ul class='filter-cats'>";
	$perma_reset = substr($perma, 0, -1);
	$filter_out .= "
		<li id='tax-reset' class='filter-cat'>
			<a title='" . __('Restablecer','whatif') . "' href='" .$perma_reset. "'><img src='" .WHATIF_BLOGTHEME. "/images/default-reset.png' alt='" . __('Restablecer','whatif') . "' /></a>
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
		if ( is_array($cat_meta) ) {
			if ( array_key_exists('image',$cat_meta) && $cat_meta['image'] != '' ) {
				$cat_img = $cat_meta['image'];
			}
		} else { $cat_img = WHATIF_BLOGTHEME. "/images/default-cat.png"; }
		$categImg = "<img src='" .$cat_img. "' alt='" .$categ->name. "' />";
		
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
