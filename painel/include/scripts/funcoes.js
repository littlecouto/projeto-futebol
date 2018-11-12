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





//MASCARA PARA MOEDA

function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode == 13) return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}


// COMO USAR
// <label><input name="consumo_tusd" type="text" id="consumo_tusd" onkeypress="return(MascaraMoeda(this,'.',',',event))" /></label>
//



//
function abrefecha(obj){ 
	var el = document.getElementById(obj); 
	if(el.style.display != "block"){ 
		el.style.display = "block"; 
	}else{ 
		el.style.display = "none"; 
	} 
} 
//




// BACKGROUD COLOR 
function bgr_color(obj, color) {
    obj.style.backgroundColor=color;
}

	// COMO USAR
	//<tr onMouseOver="bgr_color(this, '#CCCCCC')" onMouseOut="bgr_color(this, '#FFFFFF')" onclick="javascript:window.location='?pagina=ampl_peca&peca=$row[idPec]'">
//



// MÁSCARA
function formatar_mascara(src, mascara) {
	var campo = src.value.length;
	var saida = mascara.substring(0,1);
	var texto = mascara.substring(campo);
	if(texto.substring(0,1) != saida) {
		src.value += texto.substring(0,1);
	}
}
//
//Formata valor
//-----------------------------------------------------
//Funcao: MascaraMoeda
//Sinopse: Mascara de preenchimento de moeda
//Parametro:
//   objTextBox : Objeto (TextBox)
//   SeparadorMilesimo : Caracter separador de milésimos
//   SeparadorDecimal : Caracter separador de decimais
//   e : Evento
//Retorno: Booleano
//Autor: Gabriel Fróes - www.codigofonte.com.br
//-----------------------------------------------------
function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode == 13) return true;
	var t = new String(objTextBox.value);//essa linha
	if (whichCode == 8){//e para 
	objTextBox.value = t.substring(0, t.length-1);//apagar no firefox
	} 

    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////



// LIMPAR MÁSCARA
function limpar_mascara($texto){
	$chars = array(".","/","-"," "); // coloca todos aqui
	$texto = str_replace($chars,"",$texto);
	return $texto;
}
//







/* CALCULAR IDADE
function calcularidade($nasc){
	$hoje = date("Y-m-d"); //pega a data d ehoje
	$aniv = explode("-", $nasc); //separa a data de nascimento em array, utilizando o símbolo de - como separador
	$atual = explode("-", $hoje); //separa a data de hoje em array
	  
	$idade = $atual[0] - $aniv[0];
	
	if($aniv[1] > $atual[1]){ //verifica se o mês de nascimento é maior que o mês atual
		$idade--; //tira um ano, já que ele não fez aniversário ainda
	}elseif($aniv[1] == $atual[1] && $aniv[2] > $atual[2]){ //verifica se o dia de hoje é maior que o dia do aniversário
		$idade--; //tira um ano se não fez aniversário ainda
	}
	
	return $idade; //retorna a idade da pessoa em anos
}
*/
