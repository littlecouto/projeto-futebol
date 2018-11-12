<?php

/* FUNÇÃO PARA CÁLCULO DE DIFERENÇA ENTRE DATAS */ 
function diffDate($d1, $d2, $type='', $sep='-'){
	
	$d1 = explode($sep, $d1);
	$d2 = explode($sep, $d2);
 
 	switch ($type){
		case 'A':	$X = 31536000;	break;
		case 'M':	$X = 2592000;	break;
		case 'D':	$X = 86400;		break;
		case 'H':	$X = 3600;		break;
		case 'MI':	$X = 60;		break;
		default:	$X = 1;
	}
	
	return floor( ( ( mktime(0, 0, 0, $d2[1], $d2[2], $d2[0]) - mktime(0, 0, 0, $d1[1], $d1[2], $d1[0] ) ) / $X ) );
}





/* ESEMPLOS DE USO


// Calcular diferença entre Dias (3º parâmetro D).
$d1 = "2011-01-01";
$d2 = "2011-01-10";
echo diffDate($d1,$d2,'D');


// Calcular diferença entre Meses (3º parâmetro M).
$d1 = "2011-01-01";
$d2 = "2011-02-01";
echo diffDate($d1,$d2,'M');


// Calcular diferença em Minutos (3º parâmetro MI).
$d1 = "2011-01-01";
$d2 = "2011-02-01";
echo diffDate($d1,$d2,'MI');


// Calcular diferença entre Anos (3º parâmetro A).
$d1 = "2010-01-01";
$d2 = "2011-01-01";
echo diffDate($d1,$d2,'A');


// Calcular diferença em Horas (3º parâmetro H).
$d1 = "2011-01-01";
$d2 = "2011-02-01";
echo diffDate($d1,$d2,'H');


// Calcular diferença em Dias com separador “/”  (3º parâmetro D e 4º parâmetro / ).
$d1 = "2011/01/01";
$d2 = "2011/02/01";
echo diffDate($d1,$d2,'D',"/");


// Calcular diferença em Segundos (omitindo o 3º e 4º parâmetro ).
$d1 = "2011-01-01";
$d2 = "2011-02-01";
echo diffDate($d1,$d2);
*/



?>