// LIMPAR CAMPO IMPUT AO CLICAR
function limpar (objeto, msg) {
    if (objeto.value == msg)objeto.value = '';
}

function mostrar (objeto, msg) {
    if (objeto.value == '')objeto.value = msg;
}

	//COMO USAR
	//<input type="text" id="campo" onfocus="limpar(this,'Nome');" onblur="mostrar(this, 'Nome');"  />

//


