


/**
 * 
 * Fun��o comparaPeriodo - Calcula a diferen�a de  minutos, horas, dias, meses e anos entre duas datas
 * 
 * @author Robson Quaresma
 * 
 * @param string	$d1 - Primeira Data
 * @param string	$d2	- Segunda Data
 * @param string 	$type - A = ano, M = m�s, D = dia, H = hora, MI = minutos
 * @param string 	$sep	- separador da data '-' ou '/'
 * 
 * @return int - Diferen�a de  minutos, horas, dias, meses ou anos entre as datas
 * 
 * @example 
 * $d1 = "2011-01-01";
 * $d2 = "2011-02-01";
 * echo calcDifData($d1,$d2,'M');
 * 
 */
function comparaPeriodo($d1, $d2, $type='', $sep='-'){
	
	 $d1 = explode($sep, $d1);
	 $d2 = explode($sep, $d2);
	 
	switch ($type) {
		case 'A': 	$X = 31536000; 	break;
		case 'M':	$X = 2592000; 	break;
		case 'D': 	$X = 86400;		break;
		case 'H': 	$X = 3600;		break;
		case 'MI':	$X = 60;		break;
		default:	$X = 1;
	}
	 
	 return floor( ( ( mktime(0, 0, 0, $d2[1], $d2[2], $d2[0]) - mktime(0, 0, 0, $d1[1], $d1[2], $d1[0] ) ) / $X ) );
}