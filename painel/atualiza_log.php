<?php
session_start();

include_once 'include/config.php';
include_once 'include/classes/conexao.class.php';
include_once 'include/classes/login.class.php';

$lgn = new Login();
$lgn->AtualizaLog();
?>