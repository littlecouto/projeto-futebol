<div class="formulario"  style="width: 100%;">


	<?php


    include 'include/scripts/converte_data.php';
    
    // PAGINAÇÃO
    !isset($_GET['d']) ? $divisao = 1 : $divisao = $_GET['d'];
    // FIM PAGINAÇÃ O
    
    $result = mysql_query("SELECT divisao, temporada FROM jogo WHERE divisao=$divisao GROUP BY divisao, temporada ORDER BY temporada ") or die(mysql_error().' na linha '.__LINE__);
    ?>
    
    <div class="area">    
        <form action="" method="get" id="filtro" name="pesquisa">
            <table class="semCor" style="width: 300px">
                <tr>
                    <td class="t_campo"><strong>S&Eacute;RIE</strong></td>
                </tr>
                
                <tr>

                    <td><select name="d" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                            <option value="1">A</option>
                            <option value="2">B</option>
                        </select>
					</td>
                </tr>
            </table>
        </form>
   </div>     
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <th width="20%" class="t_campo">TEMPORADA</th>
        <th width="55%" class="t_campo">DIVISÃO</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        </tr>
    
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			
            
            // Tratando dados
            
            echo "	<tr>
                    <td valign=\"top\"> $row[temporada] </td>
                    <td> $row[divisao] </td>
                    <td> <a href='campeonato-jogos?t=$row[temporada]&amp;d=$row[divisao]'>Jogos</a> </td>
                    <td><a href='campeonato-info?t=$row[temporada]&amp;d=$row[divisao]'><img src='include/img/bt/bt_alterar.gif' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
                    </tr>";
        }


        ?> 	
    
    </table>


    
    
    
    
<script>
function envia(){
	document.pesquisa.submit();
}

</script>    
    
