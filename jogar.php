<?php

$db['server']       = 'localhost';
$db['user']         = 'root';
$db['password']     = '';
$db['dbname']       = 'futebol_novo';

$conn = mysql_connect($db['server'],$db['user'],$db['password']);
mysql_select_db($db['dbname'],$conn);

function show($str = ''){
	echo $str;
}

$resCamp = mysql_query("SELECT * FROM campeonato WHERE ativo=1 AND tipo=1") or show(mysql_error());
$rowCamp = mysql_fetch_array($resCamp);
$idCam = $rowCamp['idCam'];

$resJogo = mysql_query("SELECT idTem, divisao, turno, rodada FROM jogo WHERE idCom='$idCam' AND realizado=1 ORDER BY idTem DESC") or show(mysql_error());
$rowJogo = mysql_fetch_array($resJogo);
$idTem = $rowJogo['idTem'];

$resTemp = mysql_query("SELECT temporada FROM jogo_temporada WHERE idTem='$idTem'") or show(mysql_error());
$rowTemp = mysql_fetch_array($resTemp);
$temporada = $rowTemp['temporada'];

?>

<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<title>Pôfexo Manager</title>
<link href="jogar.css" rel="stylesheet">


</head>

<body oncontextmenu="return false">

<div class="rodada">
	<h1 class="temporada">1ª temporada</h1>
	<h2 class="rodada">1ª rodada</h2>
	
	<div 
		class="jogo resumo" 
		data-jogo="1" 
		data-estadio="Cícero Pompeu de Toledo" 
		data-estadio-popular="Morumbi" 

		data-mandante="São Paulo"
		data-mandante-forca="59"
		data-mandante-cor_pri="#F1F1F1"
		data-mandante-cor_sec="#D62020"
		
		data-visitante="Santos"
		data-visitante-forca="65"
		data-visitante-cor_pri="#666666"
		data-visitante-cor_sec="#FFFFFF"
		
		data-tipo="1"
		data-primeiro-jogo="true"
		data-primeiro-jogo-mandante="1"
		data-primeiro-jogo-visitante="3"

		data-mandante-formacao="4-4-2"
		data-mandante-escalacao="0,T,Edgardo Bauza;1,1,Dênis;2,3,Rodrigo Caio;3,27,Maicon;4,2,Bruno;5,6,Mena;6,7,Thiago Mendes;7,10,Ganso;8,8,Michel Bastos;9,11,Kelvin;10,9,Calleri;11,8,Cuevas"
		data-mandante-suplentes="12,22,Renan Ribeiro;13,5,Lugano;14,13,Lucão;"
		
		data-visitante-formacao="4-4-2"
		data-visitante-escalacao="0,T,Durival Júnior;1,1,Vanderlei;2,3,Leonardo;3,5,David Braz;4,6,Zeca;5,2,Victor Ferraz;6,5,Vitor Bueno;7,10,Lucas Lima;8,8,Marquinhos Gabriel;9,7,Rafael Longuine;10,9,Ricardo Oliveira;11,11,Geuvânio">
		
			<div class="equipe mandante">
				<div class="info">
					<div class="escudo" data-background="sao-paulo-futebol-clube.png"></div>
					<h3 class="equipe"></h3>
					<ul class="menu opcao"></ul>
					<ul class="menu funcao"></ul>
				</div>
				
				<ul class="jogadores" data-formacao="4-4-2">
					<li class="tecnico" data-id="1" data-posicao="Tec" data-link="" data-nome="Edgardo Bauza"></li>
					<li class="jogador goleiro" data-id="2" data-posicao="Gol" data-lado="E" data-numero="1" data-link="" data-nome="Dênis"></li>
					<li class="jogador defesa" data-id="3" data-posicao="Lat" data-lado="D" data-numero="2" data-link="" data-nome="Bruno"></li>
					<li class="jogador defesa" data-id="15" data-posicao="Zag" data-lado="D" data-numero="3" data-link="" data-nome="Rodrigo Caio"></li>
					<li class="jogador defesa" data-id="5" data-posicao="Zag" data-lado="E" data-numero="27" data-link="" data-nome="Maicon"></li>
					<li class="jogador defesa" data-id="6" data-posicao="Lat" data-lado="E" data-numero="15" data-link="" data-nome="Mena"></li>
					<li class="jogador meio_campo" data-id="7" data-posicao="Vol" data-lado="E" data-numero="25" data-link="" data-nome="Hudson"></li>
					<li class="jogador meio_campo" data-id="8" data-posicao="Vol" data-lado="D" data-numero="23" data-link="" data-nome="Thiago Mendes"></li>
					<li class="jogador meio_campo" data-id="9" data-posicao="Mei" data-lado="E" data-numero="8" data-link="" data-nome="Michael Bastos"></li>
					<li class="jogador meio_campo" data-id="10" data-posicao="Mei" data-lado="D" data-numero="13" data-link="" data-nome="Cuevas"></li>
					<li class="jogador ataque" data-id="11" data-posicao="Ata" data-lado="E" data-numero="11" data-link="" data-nome="Kelvin"></li>
					<li class="jogador ataque" data-id="12" data-posicao="Ata" data-lado="E" data-numero="37" data-link="" data-nome="Ytalo"></li>					
				</ul>
				
				<ul class="suplentes">
					<li class="jogador goleiro" data-id="13" data-posicao="Gol" data-lado="D" data-numero="22" data-link="" data-nome="Renan Ribeiro"></li>
					<li class="jogador defesa" data-id="14" data-posicao="Lat" data-lado="E" data-numero="6" data-link="" data-nome="Carlinhos"></li>
					<li class="jogador defesa" data-id="4" data-posicao="Zag" data-lado="D" data-numero="5" data-link="" data-nome="Lugano"></li>
					<li class="jogador meio_campo" data-id="16" data-posicao="Vol" data-lado="E" data-numero="21" data-link="" data-nome="João Schmidt"></li>
					<li class="jogador meio_campo" data-id="17" data-posicao="Mei" data-lado="E" data-numero="16" data-link="" data-nome="Daniel"></li>
					<li class="jogador ataque" data-id="18" data-posicao="Ata" data-lado="D" data-numero="23" data-link="" data-nome="Centurión"></li>
					<li class="jogador ataque" data-id="19" data-posicao="Ata" data-lado="D" data-numero="14" data-link="" data-nome="Alan Kardec"></li>
				</ul>
			</div>
			
			<div class="equipe visitante">
				<div class="info">
					<div class="escudo" data-background="santos-futebol-clube.png"></div>
					<h3 class="equipe"></h3>
				</div>
				
				<ul class="jogadores" data-formacao="4-4-2">
					<li class="tecnico" data-id="1" data-posicao="Tec" data-link="" data-nome="Dorival Júnior"></li>
					<li class="jogador goleiro" data-id="2" data-posicao="Gol" data-lado="E" data-numero="1" data-link="" data-nome="Vanderlei"></li>
					<li class="jogador defesa" data-id="3" data-posicao="Lat" data-lado="D" data-numero="2" data-link="" data-nome="Victor Ferraz"></li>
					<li class="jogador defesa" data-id="4" data-posicao="Zag" data-lado="D" data-numero="5" data-link="" data-nome="David Braz"></li>
					<li class="jogador defesa" data-id="5" data-posicao="Zag" data-lado="E" data-numero="27" data-link="" data-nome="Gustavo Henrique"></li>
					<li class="jogador defesa" data-id="6" data-posicao="Lat" data-lado="E" data-numero="15" data-link="" data-nome="Zeca"></li>
					<li class="jogador meio_campo" data-id="7" data-posicao="Vol" data-lado="E" data-numero="25" data-link="" data-nome="Renato"></li>
					<li class="jogador meio_campo" data-id="8" data-posicao="Mei" data-lado="D" data-numero="23" data-link="" data-nome="Lucas Lima"></li>
					<li class="jogador meio_campo" data-id="9" data-posicao="Mei" data-lado="E" data-numero="8" data-link="" data-nome="Vitor Bueno"></li>
					<li class="jogador ataque" data-id="10" data-posicao="Ata" data-lado="D" data-numero="10" data-link="" data-nome="Gabriel"></li>
					<li class="jogador ataque" data-id="11" data-posicao="Ata" data-lado="E" data-numero="9" data-link="" data-nome="Ricardo Oliveira"></li>
					<li class="jogador ataque" data-id="12" data-posicao="Ata" data-lado="E" data-numero="12" data-link="" data-nome="Paulinho"></li>					
				</ul>
				
				<ul class="suplentes">
					<li class="jogador goleiro" data-id="13" data-posicao="Gol" data-lado="E" data-numero="22" data-link="" data-nome="Vladimir"></li>
					<li class="jogador defesa" data-id="14" data-posicao="Lat" data-lado="E" data-numero="6" data-link="" data-nome="Caju"></li>
					<li class="jogador defesa" data-id="15" data-posicao="Zag" data-lado="E" data-numero="3" data-link="" data-nome="Lucas Veríssimo"></li>
					<li class="jogador meio_campo" data-id="16" data-posicao="Vol" data-lado="D" data-numero="21" data-link="" data-nome="Elano"></li>
					<li class="jogador meio_campo" data-id="17" data-posicao="Mei" data-lado="D" data-numero="16" data-link="" data-nome="Serginho"></li>
					<li class="jogador ataque" data-id="18" data-posicao="Ata" data-lado="E" data-numero="23" data-link="" data-nome="Joel"></li>
					<li class="jogador ataque" data-id="19" data-posicao="Ata" data-lado="E" data-numero="14" data-link="" data-nome="Neto Berola"></li>
				</ul>
			</div>
		
		</div>
</div>


<script src="jquery-3.0.0-alpha1.js"></script>
<script src="include/js/jquery.bpopup.min.js"></script>
<script src="jogar.js"></script>
</body>
</html>