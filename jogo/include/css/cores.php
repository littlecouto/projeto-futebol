<?php
session_start();
header("Content-type: text/css");

include_once '../classes/funcoes.php';
include_once '../php/config.php';

echo "
body {
	background-color: $cor_pri;
}

";

?>