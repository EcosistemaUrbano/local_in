function likeThis(postId) {
	if (postId != '') {
		jQuery('#iLikeThis-'+postId+' .counter').text('...');
		
		jQuery.post(voteFunctionUrl,
			{ id: postId },
			function(data){
				jQuery('#iLikeThis-'+postId+' .counter').text(data);
			});
	}
}
