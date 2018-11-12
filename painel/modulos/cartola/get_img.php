<?php 
include("../../lib/mpdf60/mpdf.php");



$html = file_get_contents('http://ewebtecnologia.com.br/vini/brasfoot/seg/modulos/cartola/ver_time.php?q=pagodealegria?auth='.md5('ledbetter'));

$mpdf=new mPDF('c'); 
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;


?>