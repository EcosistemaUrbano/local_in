jQuery(document).ready(function($){
	$('#valorcategory').hide();
	var catSelected = [];
	$('.cat-boton').bind('click', function(){
		catId = $(this).attr('id');
		if ( $(this).hasClass('active') ) {
			catSelected.splice( $.inArray(catId, catSelected), 1 );
		} else {
			catSelected.push(catId);
		}
		$(this).toggleClass('active');
		$('#valorcategory').val(catSelected);
	})
});
