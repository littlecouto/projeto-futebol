<div id="menu">
    <ul class="nav">
    <li><a href="painel-logout" target="_self"> SAIR </a></li>
	<?php
	// RESGATANDO MÓDULO E ITEM ATUAIS
	$rowAtu = mysql_fetch_array(mysql_query("SELECT A.idMod, B.idIte, B.idPri FROM painel_modulo A INNER JOIN painel_modulo_item B ON A.idMod=B.idMod WHERE A.url='$_GET[url]' OR B.url='$_GET[url]'"));
	
	// RESGATANDO MÓDULOS
    $queryMen = "SELECT B.idMod, B.nome, B.url FROM painel_permissao A INNER JOIN painel_modulo_item B ON A.idIte=B.idIte WHERE B.ativo=1 AND A.idUsu='$_SESSION[USUARIOSEG]' AND B.principal=1 AND B.tipo=1 GROUP BY B.idIte ORDER BY B.ordem DESC, B.nome DESC";
	
	$resMen = mysql_query($queryMen) or die(mysql_error());
	while($rowMen = mysql_fetch_array($resMen)){
	
		$classMod = $rowAtu['idMod'] == $rowMen['idMod'] ? 'class="ativo"': '';
		echo  	"<li>
					<a href=\"$rowMen[url]\" target=\"_self\" $classMod> $rowMen[nome] </a>
					<ul id=\"submenu\">";
				
				// RESGATANDO SUBMENU DE ITENS
				$queryIte = "SELECT A.idIte, A.nome, A.url, A.pagina FROM painel_modulo_item A INNER JOIN painel_permissao B ON A.idIte=B.idIte WHERE A.ativo=1 AND B.idUsu='$_SESSION[USUARIOSEG]' AND A.idPri=0 AND A.idMod='$rowMen[idMod]' GROUP BY A.idIte";
				$resIte = mysql_query($queryIte) or die(mysql_error());
				while($rowIte = mysql_fetch_array($resIte)){
					
					
					$clasIte = ($rowAtu['idIte'] == $rowIte['idIte'] or $rowAtu['idPri'] == $rowIte['idIte']) ? 'class="ativo"': '';
					echo "<li>
						 <a href=\"$rowIte[url]\" target=\"_self\" $clasIte> $rowIte[nome] </a>";
						 
						 // RESGATANDO SUBITENS
						$querySub = "SELECT A.idIte, A.nome, A.url, A.pagina FROM painel_modulo_item A INNER JOIN painel_modulo_item B ON A.idPri=B.idIte INNER JOIN painel_permissao C ON A.idIte=C.idIte WHERE C.idUsu='$_SESSION[USUARIOSEG]' AND A.idPri='$rowIte[idIte]' AND A.tipo=1 GROUP BY A.idIte";
						$resSub = mysql_query($querySub) or die(mysql_error());
						// VERIFICANDO SE EXISTE SUBITEM
						if(mysql_num_rows(mysql_query($querySub))){
							echo "<ul id=\"submenuitem\">";
							while($rowSub = mysql_fetch_array($resSub)){
								$classSub = $rowAtu['idIte'] == $rowSub['idIte'] ? 'class="ativo"': '';
	
								echo "<li><a href=\"$rowSub[url]\" target=\"_self\" $classSub> $rowSub[nome] </a></li>";
							}
							echo "</ul>";
						}
						
					echo "</li>";
				}
		echo	"	</ul>
				</li>";				
	}
	?>
    </ul>
</div>


