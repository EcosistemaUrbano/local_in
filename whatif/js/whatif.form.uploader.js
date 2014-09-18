jQuery(function($) {
	var fileInput = $('#blas');
	var wrapper = $('<div/>').css({'height':'0','width':'0','overflow':'hidden'});
	var fileInputWrapped = $('#blas').wrap(wrapper);

	$('#media-boton').click(function(){
		if ( $(this).hasClass('media-cancel') ) {
			fileInput.wrap('<form>').closest('form').get(0).reset();
			fileInput.unwrap();
			$(this).text("+");
			$('#upload .media-feedback').html(formUploaderL10n.mediaFeedback);

		} else {
			fileInput.click();
			$(this).text('x');
			fileInput.change(function(){
				$('#upload .media-feedback').text(fileInput.val());
			})

		}
		$(this).toggleClass("media-cancel");

	})

});
