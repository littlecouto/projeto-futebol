<?php
// PERMISS�ES




	// MASTER
	if($master == 1){
		
		// Config. Geral
		$LISTA[] = 2;  // GERENCIAMENTO DE M�DULOS
		$LISTA[] = 1;  // GERENCIAMENTO DE USU�RIOS
		$LISTA[] = 3;  // INFORMA��ES DO PROPRIET�RIO
		$LISTA[] = 11;  // GERENCIAMENTO DE PLANOS
		$LISTA[] = 18;  // CATEGORIAS FINANCEIRAS
		$LISTA[] = 21;  // CATEGORIAS DE FORNECEDORES
		
		// Gest�o
		$LISTA[] = 5;  // LOG DE ACESSOS
		$LISTA[] = 4;  // LOG DE A��ES
		$LISTA[] = 12;  // CURR�CULOS
		$LISTA[] = 22;  // DOWNLOAD DE CLIENTES (EMAILS)
		
	}


	// CLIENTE
	if($permissao_cliente == 2){
		$LISTA[] = 7;  // ADICIONAR CLIENTE
		$LISTA[] = 8;  // LISTAGEM DE CLIENTES
		$LISTA[] = 13;  // ENVIAR MENSAGEM
	}
	elseif($permissao_cliente == 1){
		$LISTA[] = 8;  // LISTAGEM DE CLIENTES
		
	}
	
	
	// HOSPEDAGEM
	if($permissao_hospedagem == 2){
		$LISTA[] = 9;  // ADICIONAR HOSPEDAGEM
		$LISTA[] = 10;  // LISTAGEM DE HOSPEDAGEM
	}
	elseif($permissao_hospedagem == 1){
		$LISTA[] = 10;  // LISTAGEM DE HOSPEDAGEM
		
	}
	
	
	
	
	// FORNECEDOR
	if($permissao_fornecedor == 2){
		$LISTA[] = 14;  // ADICIONAR CLIENTE
		$LISTA[] = 15;  // LISTAGEM DE CLIENTES
	}
	elseif($permissao_cliente == 1){
		$LISTA[] = 15;  // LISTAGEM DE CLIENTES
		
	}
	
	
	
	
	// FINANCEIRO
	if($permissao_financeiro == 2){
		$LISTA[] = 19;  // RECEITAS
		$LISTA[] = 20;  // DESPESAS
	}
	elseif($permissao_financeiro == 1){
		$LISTA[] = 19;  // RECEITAS
		$LISTA[] = 20;  // DESPESAS
	}

	
	// FINANCEIRO
	if($permissao_campanha == 2){
		$LISTA[] = 27;  // ADICIONAR CAMPANHA
		// $LISTA[] = 20;  // DESPESAS
	}
	elseif($permissao_campanha == 1){
		$LISTA[] = 27;  // ADICIONAR CAMPANHA
		// $LISTA[] = 20;  // DESPESAS
	}
	







// EXCLUINDO PERMISS�ES ANTIGAS
mysql_query("DELETE FROM painel_permissao WHERE idUsu='$_REQUEST[cod]'");



// APLICANDO PERMISS�ES
if(count($LISTA)>0){
					
	// ADICIONANDO AS PERMISS�ES
	foreach($LISTA as $item){
			
		// SELECIONANDO O M�DULO AO QUAL O ITEM PERTENCE
		$rowMod = mysql_fetch_array(mysql_query("SELECT idMod FROM painel_modulo_item WHERE idIte='$item'"));
		
		// VERIFICANDO SE O USU�RIO J� POSSUI PERMISS�O AO M�DULO ATUAL
		$resultModAtu = mysql_query("SELECT idPer FROM painel_permissao WHERE idUsu='$COD_USU' AND idMod='$rowMod[idMod]' AND tipo='MOD'");
		if(mysql_num_rows($resultModAtu) == 0){
			
			// ADICIONANDO A PERMISS�O ATUAL - M�DULO
			$query = "INSERT INTO painel_permissao(idUsu, idMod, tipo) VALUES('$COD_USU', '$rowMod[idMod]', 'MOD')";
			mysql_query($query);
			
			// PAINEL HIST�RICO
			$query = addslashes($query);
			mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'INSERT', '$query')") or die (mysql_error());
			//
		}
		
		// GRAVANDO A PERMISS�O ATUAL - ITEM
		$query = "INSERT INTO painel_permissao(idUsu, idMod, idIte, tipo) VALUES($COD_USU, $rowMod[idMod], $item, 'ITEM')";
		mysql_query($query);
		
		// PAINEL HIST�RICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'INSERT', '$query')") or die (mysql_error());
		//
		
	}
}
//


?>