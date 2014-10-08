(function($){
	$.fn.validator = function(opts){
		$(this).find('.notFilled').live('keyup', function(){
			if($(this).val()!="" || $(this).val()!="Describe tu idea (140 caracteres como máximo)"){
				$(this).removeClass('notFilled');
			}
		});
		return $(this).submit(function(evt){
			$(this).find('.required').each(function(){
				if ($(this).attr('value') == ''|| $(this).val()=="Describe tu idea (140 caracteres como máximo)"){
					var opcion = $(this).attr("id");
					if (opcion == "cajaterm") opcion = "Palabras clave";
					if (opcion == "valorcategory") opcion = "Categoria";
					if (opcion == "cajadescripcion") opcion = "Descripcion";
					alert("Falta por rellenar el campo: "+opcion+".\n\nPor favor vuelva hacia atras para completarlo. \n\nGracias."); 
					$(this).addClass('notFilled');
					evt.preventDefault();
				}
			});
			$(this).find('.notFilled').first().focus();
		});
	};
})(jQuery);

jQuery(document).ready(function(){
	jQuery('form').validator();     
});

