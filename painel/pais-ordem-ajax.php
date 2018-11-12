<?php
echo "<pre>";
print_r($_POST);
echo "</pre>";
//exit;

$importante = $_GET['i'];

$i = $importante == 1 ? 1: 33;
foreach ($_POST['item'] as $idPai) {
	$resPai = mysql_query("SELECT titulo FROM pais WHERE idPai='$idPai'") or die(mysql_error());
	$rowPai = mysql_fetch_array($resPai);
	mysql_query("UPDATE pais SET ordem='$i', importante='$importante', url='$url' WHERE idPai='$idPai' LIMIT 1") or die(mysql_error());	
	$i++;
}

?>