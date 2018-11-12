




<!-- ATUALIZA O LOG DO USUÁRIO 
<script type="text/javascript">
$(document).ready(function () {
		$.post("<?php echo $SISTEMA['URL']?>/atualiza_log.php", { ACAO: "ATUALIZAR" }, function(dados){ $("#resposta").html(dados); });
});
</script>
<div id="resposta" style="display:none;"> </div>
 FIM -->


<?php
//pegando dados do cliente
$pegaEmpresa = mysql_fetch_array(mysql_query("SELECT * FROM painel_empresa WHERE idEmp='1'")) or die (mysql_error());
?>


<!-- Site -->
<div id="area">

    <!-- Central -->
    <div id="central">

    <!-- Coluna esquerda -->
    <div id="col-esq">
    
    
    	<div id="logo" onclick="javascript:location.href='<?php echo $SISTEMA['URL']?>';" style="cursor:pointer;">&nbsp;</div>
        
        <!-- Menu -->
        <ul id="nav">
        
        	<?php
			// SELECIONANDO AS PERMISSÕES E INFORMAÇÕES DOS MÓDULOS
			$resultMod = mysql_query("SELECT a.idMod, b.nome FROM painel_permissao a JOIN painel_modulo b ON (a.idMod = b.idMod) WHERE a.idUsu='$_SESSION[USUARIO]' AND a.tipo='MOD' ORDER BY b.ordem");
			while($rowMod = mysql_fetch_array($resultMod)){
				echo  "	<li>
						<a href=\"javascript:void(0)\" target=\"_self\"> $rowMod[nome] </a>
						<ul class=\"sub\">";
				
				// SELECIONANDO AS PERMISSÕES E INFORMAÇÕES DOS ITENS (MÓDULO ATUAL)
				$resultItem = mysql_query("SELECT a.idIte, b.nome, b.url, b.ativo, b.pagina FROM painel_permissao a JOIN painel_modulo_item b ON (a.idIte = b.idIte) WHERE a.idUsu='$_SESSION[USUARIO]' AND a.tipo='ITEM' AND a.idMod=$rowMod[idMod] ORDER BY b.ordem");
				while($rowItem = mysql_fetch_array($resultItem)){
					$rowItem['url'] = $SISTEMA['MODULOS'].'/'.$rowItem['url'];

					// VERIFICANDO A ABERTURA DA PÁGINA
					if($rowItem['pagina'] > 0) $target='target="_self"'; else $target='target="_blank"';
					
					// EXIBINDO O SUBITEM
					if($rowItem['ativo'] == true) echo "<li><a href=\"$rowItem[url]\" $target> $rowItem[nome] </a></li>";
					
				}
				echo '	</ul>
						</li>';	
					
			}//
			?>
            
            <li>
            <a href="<?php echo $SISTEMA['URL'] ?>/logout.php" target="_self"> MEUS DADOS </a>
                <ul class="sub">
                <?php
				// GERANDO CHAVE
				$usuario = $_SESSION['USUARIO'];
				$chave = md5($usuario);
				?>
				<li>
				<a href="<?php echo $SISTEMA['URL'] ?>/modulos/config_geral/alt_senha.php?idUsu=<?php echo $usuario?>&amp;chave=<?php echo $chave?>" target="_self"> ATUALIZAR CADASTRO </a>
				</li>
                
                <li>
                <a href="<?php echo $SISTEMA['URL'] ?>/historico_acessos.php" target="_self"> HIST&Oacute;RICO DE ACESSOS </a>
                </li>
                </ul>
            </li>
            
            
            <li>
            <a href="<?php echo $SISTEMA['URL'] ?>/logout.php" target="_self"> SAIR </a>
            </li>

            


           
            
           
            
            
        </ul>
        <!-- Fim menu -->
    
    </div>
    <!-- Fim coluna esquerda -->
	<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script>
    $('ul#nav li a').click(
		function(){
			if($(this).next('ul').attr('class') ===  'sub abre'){
				$(this).next('ul').removeClass('abre').addClass('fecha');
			}else{
				$(this).next('ul').removeClass('fecha').addClass('abre');
			}
		}
	);
    </script>
    
    