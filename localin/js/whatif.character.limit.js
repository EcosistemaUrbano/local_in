CharacterCount = function(TextArea,FieldToCount){
	var myField = document.getElementById(TextArea);
	var myLabel = document.getElementById(FieldToCount); 
	if(!myField || !myLabel){return false}; // catches errors
	var MaxChars =  myField.maxLengh;
	if(!MaxChars){MaxChars = myField.getAttribute('maxlength'); };
	if(!MaxChars){return false};
	var remainingChars =  MaxChars - myField.value.length
	if(remainingChars == 1 )
	myLabel.innerHTML = formLimitL10n.infoOne
	else if(remainingChars >= 2 )
	myLabel.innerHTML = remainingChars+ " " +formLimitL10n.infoPlus
	else
	myLabel.innerHTML = formLimitL10n.infoMax
}
//SETUP!!
setInterval(function(){CharacterCount('cajadescripcion','info')},55);
