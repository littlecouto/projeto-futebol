
/***************************** VReport *****************************
*
* Relatório em HTML com cabeçalho e rodapé para impressão
*
* Criado por Vinícius Nunes Lage
* Contatos: op.vini@gmail.com ou http://www.isecretaria.net/vinicius
* Direitos reservados desde 2009
* Este script pode ser utilizado por qualquer pessoa para qualquer fim
* Só é necessário que cite no sistema que você utiliza o VReport
*
*para usar basta colocar antes do fechamento do body o link puxando esse arquivo
*linka os 2 arquivos css "print_relatirio" e "screen_relatorio"
*********************************************************************/

var _VReportTable = '<table id="_VReportTable"><thead><div class="linha"><th id="_VReportTHead">&nbsp;</th></div></thead><tfoot><div class="linha"><th id="_VReportTFoot">&nbsp;</th></div></tfoot><tbody><div class="linha"><td valign="top"><div id="_VReportContentClient"></div></div></div></tbody>';var _VReportContentClient = document.getElementById('_VReportContent').innerHTML;document.getElementById('_VReportContent').innerHTML = _VReportTable;document.getElementById('_VReportContentClient').innerHTML = _VReportContentClient;document.getElementById('_VReportTHead').style.height = document.getElementById('_VReportHeader').clientHeight + "px";document.getElementById('_VReportTFoot').style.height = document.getElementById('_VReportFooter').clientHeight + "px";