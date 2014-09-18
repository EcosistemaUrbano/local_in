function limita(elEvento, maximoCaracteres) {
  var elemento = document.getElementById("cajadescripcion");

  // Obtener la tecla pulsada 
  var evento = elEvento || window.event;
  var codigoCaracter = evento.charCode || evento.keyCode;
  // Permitir utilizar las teclas con flecha horizontal
  if(codigoCaracter == 37 || codigoCaracter == 39) {
    return true;
  }

  // Permitir borrar con la tecla Backspace y con la tecla Supr.
  if(codigoCaracter == 8 || codigoCaracter == 46) {
    return true;
  }
  else if(elemento.value.length >= maximoCaracteres ) {
    return false;
  }
  else {
    return true;
  }
}

function actualizaInfo(maximoCaracteres) {
  var elemento = document.getElementById("cajadescripcion");
  var info = document.getElementById("info");

	if(elemento.value.length >= maximoCaracteres )
		info.innerHTML = formLimitL10n.infoMax;
	else if(maximoCaracteres-elemento.value.length == 1 )
		info.innerHTML = formLimitL10n.infoOne;
	else
		info.innerHTML = (maximoCaracteres-elemento.value.length)+" "+formLimitL10n.infoPlus;
	
}
