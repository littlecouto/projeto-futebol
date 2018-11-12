<?php


include_once 'include/scripts/converte_data.php';



if(!isset($_REQUEST['ACAO']) or $_REQUEST['ACAO'] != 'ATUALIZAR'){

	//Selecionando dados do usuário a ser atualizado
	$sql 	= "SELECT * FROM painel_config LIMIT 1";
	
	$query 	= mysql_query($sql) or die (mysql_error()); // Proteção SQL Injection
	$rowCon = mysql_fetch_array($query);
	
	


}elseif($_POST['ACAO'] == 'ATUALIZAR'){
	
	
	
	if($_POST['sistema_nome'] == ""){
		$aviso = "Informe o título do sistema!";
		echo "<script> alert('$aviso'); history.go(-1)</script>";
		exit;
	
	}elseif($_POST['sistema_email'] == ""){
		$aviso = "Informe o e-mail do sistema!";
		echo "<script> alert('$aviso'); history.go(-1)</script>";
		exit;
	
	}elseif($_POST['nome'] == ''){
		$aviso = "Informe o nome do proprietário!";
		echo "<script> alert('$aviso'); history.go(-1)</script>";
		exit;
	
	}elseif($_POST['email'] == ''){
		$aviso = "Informe o e-mail do proprietário!";
		echo "<script> alert('$aviso'); history.go(-1)</script>";
		exit;
	
	}elseif($_POST['sistema_site'] == ''){
		$aviso = "Informe o endereço do site!";
		echo "<script> alert('$aviso'); history.go(-1)</script>";
		exit;
	
	}elseif($_POST['sistema_admin'] == ''){
		$aviso = "Informe o endereço do sistema!";
		echo "<script> alert('$aviso'); history.go(-1)</script>";
		exit;
	
	
	}elseif($_POST['cor_pri'] == ''){
		$aviso = "Informe a cor principal!";
		echo "<script> alert('$aviso'); history.go(-1)</script>";
		exit;
	
	}elseif($_POST['cor_seg'] == ''){
		$aviso = "Informe a cor secundária!";
		echo "<script> alert('$aviso'); history.go(-1)</script>";
		exit;
	
			
	}else{
		
		// Tratando os dados
		$sistema_nome	= addslashes($_POST['sistema_nome']);
		$sistema_email	= addslashes($_POST['sistema_email']);
		$sistema_site	= addslashes($_POST['sistema_site']);
		$sistema_admin	= addslashes($_POST['sistema_admin']);
		$email_senha	= addslashes($_POST['email_senha']);
		$email_smtp		= addslashes($_POST['email_smtp']);
		$email_porta	= addslashes($_POST['email_porta']);
		
		$nome 			= addslashes($_POST['nome']);
		$email			= addslashes($_POST['email']);

		$cor_pri		= addslashes($_POST['cor_pri']);
		$cor_seg		= addslashes($_POST['cor_seg']);

		$nome 			= strtoupper($nome);
		$email 			= strtolower($email);
	
			
		// Definindo se a senha será atualizada
		$altsenha = '';
		if($_POST['senha'] != '')  $altsenha = " senha='$senha',";
		
		mysql_query("TRUNCATE painel_config");
		//GRAVANDO OS DADOS		
		$query = "INSERT INTO painel_config (sistema_nome, sistema_email, nome, email, email_senha, email_smtp, email_porta, url_site, url_seg, cor_pri, cor_seg)VALUE('$sistema_nome', '$sistema_email', '$nome', '$email', '$email_senha', '$email_smtp', '$email_porta', '$sistema_site', '$sistema_admin', '$cor_pri', '$cor_seg')";
		$gravou = mysql_query($query) or die(mysql_error());
		
		mysql_query("TRUNCATE painel_config_variavel") or die(mysql_error());
		
		$queryVar = "INSERT INTO painel_config_variavel(variavel, valor)VALUES";
		foreach($_POST['variavel'] as $k => $v){
			if($v != ''){
				$valor	  = addslashes($_POST['valor'][$k]);
				$variavel = addslashes($v);
				$queryVar .= "('$variavel', '$valor'),";
				$add++;
			}
		}
		$queryVar = substr($queryVar, 0, -1);
		
		if($add>0){
			mysql_query($queryVar) or die(mysql_error());
		}
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query)VALUE('$_SESSION[USUARIO]', 'UPDATE', '$query')") or die (mysql_error());
		//

					
		// Verificando a gravação
		if($gravou==false){
			$aviso = 'HOUVE UM ERRO AO ATUALIZAR OS DADOS';
			echo "<script> alert('$aviso'); window.history.go(-1); </script>";
			
		}else{
			
        if($_FILES["logotipo"]['size'] > 0){ // Verificando se a imagem foi realmente selecionada
            // Aqui incluimos a classe 
            include_once('include/classes/upload.class.php'); 

            // Nome da imagem
            $tituloImg = 'logo-seg';
        	if(file_exists("$DirLogo/$tituloImg.png")){
				unlink("$DirLogo/$tituloImg.png");
			}
            
            // Instanciamos o objeto Upload   
            $handle = '';
            $handle = new Upload($_FILES["logotipo"]);   
            // 
            
            // Então verificamos se o arquivo foi carregado corretamente    
            if ($handle->uploaded) {    
                // Aqui nos devifimos nossas configurações de imagem       
                $handle->image_resize           = true;         // redimensinoar    
                $handle->image_ratio_x          = false;        // dimensionar largura na proporção
                $handle->image_ratio_y          = true;        // dimensionar altura na proporção
                $handle->image_x                = 350;          // largura 
                //$handle->image_y                = 150;          // altura 
                $handle->image_convert          = 'png';        // converte para JPG
                $handle->jpeg_quality           = 85;           // qualidade
                $handle->file_new_name_body     = $tituloImg;   // nome do arquivo da imagem
                $handle->process($DirLogo);             // Pasta onde a imagem será armazenada              
                $handle-> Clean();                              // Excluir os arquivos temporarios
                
            }else{ // Caso Erro
                $aviso = "Erro ao gravar o arquivo!";       
                echo "<script> alert('$aviso'); </script>";
            } 
        }
        // FIM UPLOAD

        if($_FILES["favicon"]['size'] > 0){ // Verificando se a imagem foi realmente selecionada
            // Aqui incluimos a classe 
            include_once('include/classes/upload.class.php'); 

            // Nome da imagem
            $tituloImg = 'favicon-seg';
        	if(file_exists("$DirFavicon/$tituloImg.png")){
				unlink("$DirFavicon/$tituloImg.png");
			}
            
            // Instanciamos o objeto Upload   
            $handle = '';
            $handle = new Upload($_FILES["favicon"]);   
            // 
            
            // Então verificamos se o arquivo foi carregado corretamente    
            if ($handle->uploaded) {    
                // Aqui nos devifimos nossas configurações de imagem       
                $handle->image_resize           = true;         // redimensinoar    
                $handle->image_ratio_x          = false;        // dimensionar largura na proporção
                $handle->image_ratio_y          = true;        // dimensionar altura na proporção
                $handle->image_x                = 50;          // largura 
                //$handle->image_y                = 150;          // altura 
                $handle->image_convert          = 'png';        // converte para JPG
                $handle->jpeg_quality           = 85;           // qualidade
                $handle->file_new_name_body     = $tituloImg;   // nome do arquivo da imagem
                $handle->process($DirFavicon);             // Pasta onde a imagem será armazenada              
                $handle-> Clean();                              // Excluir os arquivos temporarios
                
            }else{ // Caso Erro
                $aviso = "Erro ao gravar o arquivo!";       
                echo "<script> alert('$aviso'); </script>";
            } 
        }
        // FIM UPLOAD
			
			$aviso = 'DADOS ATUALIZADOS COM SUCESSO';
			echo "<script> alert('$aviso'); location.href='painel-config'; </script>";
			exit;
		}
	}

}
?>







<div class="formulario">

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
<input type="hidden" name="ACAO" value="ATUALIZAR" />
<input type="hidden" name="cod" value="<?php echo $_REQUEST['cod']?>" />
<input type="hidden" name="chave" value="<?php echo $_REQUEST['chave']?>" />

	<div class="area">
    	<h2>SISTEMA</h2>
        <div class="linha">
        <div class="t_campo">T&Iacute;TULO</div>
        <div class="campo"><label><input name="sistema_nome" type="text" id="sistema_nome" class="obrigatorio" size="75" maxlength="50" value="<?php echo $rowCon['sistema_nome']; ?>" /></label></div>
        </div>
      
        <div class="linha">
        <div class="t_campo">ENDERE&Ccedil;O DO SITE</div>
        <div class="campo"><label><input name="sistema_site" type="text" id="sistema_site" class="obrigatorio" value="<?php echo $rowCon['url_site']; ?>" size="30" maxlength="150" /></label></div>
        </div>
      
        <div class="linha">
        <div class="t_campo">ENDERE&Ccedil;O DO SISTEMA</div>
        <div class="campo"><label><input name="sistema_admin" type="text" id="sistema_admin" class="obrigatorio" value="<?php echo $rowCon['url_seg']; ?>" size="30" maxlength="150" /></label></div>
        </div>
        
        
   	</div>
	<div class="area">
    	<h2>PROPRIET&Aacute;RIO</h2>
        <div class="linha">
        <div class="t_campo">NOME</div>
        <div class="campo"><label><input name="nome" type="text" id="nome" class="obrigatorio" size="75" maxlength="50" value="<?php echo $rowCon['nome']; ?>" /></label></div>
        </div>

        <div class="linha">
          <div class="t_campo">E-MAIL</div>
        <div class="campo"><label><input name="email" class="obrigatorio" type="text" id="email" value="<?php echo $rowCon['email']; ?>" size="70" maxlength="150" /></label></div>
      </div>
        
    
   	</div>

	<div class="area">
    	<h2>E-MAIL</h2>
        <div class="linha">
        <div class="t_campo">E-MAIL</div>
        <div class="campo"><label><input name="sistema_email" type="text" id="sistema_email" class="obrigatorio" size="75" maxlength="50" value="<?php echo $rowCon['sistema_email']; ?>" /></label></div>
        </div>

        <div class="linha">
          <div class="t_campo">SENHA</div>
        <div class="campo"><label><input name="email_senha" class="obrigatorio" type="text" id="email_senha" value="<?php echo $rowCon['email_senha']; ?>" size="70" maxlength="150" /></label></div>
      </div>
        
        <div class="linha">
          <div class="t_campo">SMTP</div>
        <div class="campo"><label><input name="email_smtp" class="obrigatorio" type="text" id="email_smtp" value="<?php echo $rowCon['email_smtp']; ?>" size="70" maxlength="150" /></label></div>
      </div>
        
        <div class="linha">
          <div class="t_campo">PORTA</div>
        <div class="campo"><label><input name="email_porta" class="obrigatorio" type="text" id="email_porta" value="<?php echo $rowCon['email_porta']; ?>" size="70" maxlength="150" /></label></div>
      </div>
        
    
   	</div>

     
	<div class="area">
    	<h2>LOGOTIPO E CORES</h2>
            
        <div class="linha">
        <div class="t_campo">LOGOTIPO</div>
        <div class="campo"><label><input name="logotipo" type="file" id="logotipo" /></label></div>
        </div>

        <div class="linha">
        <div class="t_campo">FAVICON</div>
        <div class="campo"><label><input name="favicon" type="file" id="favicon" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">COR PRINCIPAL</div>
        <div class="campo"><label>
        <input name="cor_pri" type="text" id="cor_pri" class="obrigatorio" value="<?php echo $rowCon['cor_pri']; ?>" size="32" maxlength="7" style="width: 75px" />
        <input type="color" id="cor1" style="width: 27px; border: 1px solid #000;padding: 0px;height: 27px;" value="<?php echo $rowCon['cor_pri']; ?>" />
        </label></div>
        
        </div>
        
        <div class="linha">
        <div class="t_campo">COR SECUND&Aacute;RIA </div>
        <div class="campo"><label>
        <input name="cor_seg" type="text" id="cor_seg" class="obrigatorio" size="32" maxlength="7" value="<?php echo $rowCon['cor_seg']; ?>"  style="width: 75px" />
        <input type="color" id="cor2" style="width: 27px; border: 1px solid #000;padding: 0px;height: 27px;" value="<?php echo $rowCon['cor_seg']; ?>" />
        </label></div>
        </div>

   	</div>
    <div class="area adicionar">
       <h2>VARI&Aacute;VEIS</h2>
        <div class="linha">
        <div class="t_campo"> </div>
        <div class="campo">
        <a id="add" href="javascript:void(0)">ADICIONAR</a>
        
        <?php
        	$resVar = mysql_query("SELECT id, variavel, valor FROM painel_config_variavel WHERE ativo=1") or die(mysql_error());
			while($rowVar = mysql_fetch_array($resVar)){
				echo "
				<label><span data-id=\"var$rowVar[id]\" class=\"variavel\">$</span>
				<input name=\"variavel[]\" data-id=\"var$rowVar[id]\" type=\"text\" size=\"32\" maxlength=\"100\" value=\"$rowVar[variavel]\" style=\"width: 146px\" />
				<span class=\"igual\" data-id=\"var$rowVar[id]\">=</span>
				<input name=\"valor[]\" data-id=\"var$rowVar[id]\" type=\"text\" size=\"32\" maxlength=\"100\" value=\"$rowVar[valor]\" style=\"width: 346px\" >
				<a class=\"del\" data-id=\"var$rowVar[id]\" onclick=\"DelVar('var$rowVar[id]')\" href=\"javascript:void(0)\">REMOVER</a></label>";
			}
		
		?><label>
        <span class="variavel" data-id="varPag">$</span>
        <input name="variavel[]" data-id="varPag" type="text" size="32" maxlength="100"  style="width: 146px" />
        <span class="igual" data-id="varPag">=</span>
        <input name="valor[]" data-id="varPag" type="text" size="32" maxlength="100"  style="width: 346px" />
        <a class="del" data-id="varPag" onclick="DelVar('varPag')" href="javascript:void(0)">REMOVER</a>
        </label>
        </div>
        </div>
    </div> 
     

    
    
    
    
     
     
     <button type="submit"> ATUALIZAR INFORMAÇÕES </button>
     <button type="button" onclick="javascript:history.go(-1);"> VOLTAR </button>
    
	</form>

</div>




<script>
var i = 1;
$('a#add').click(function(){
	$('.adicionar .campo').append(
	'<label>'+
	'<span class="variavel" data-id="'+i+'">$</span>'+
	'<input name="variavel[]" data-id="'+i+'" type="text" size="32" maxlength="100" style="width: 146px" />'+
	'<span class="igual" data-id="'+i+'">=</span>'+
	'<input name="valor[]" data-id="'+i+'" type="text" size="32" maxlength="100" style="width: 346px" />'+
	'<a href="javascript:void(0)" class="del" data-id="'+i+'" onclick="DelVar(\''+i+'\')">REMOVER</a>'+
	'</label>');
	$('input[name*=variavel][data-id="'+i+'"]').focus();
	i++;
});
function DelVar(id){
	$('[data-id='+id+']').remove();
}
$('#cor1').change(function(){
		$('#cor_pri').val($(this).val())
	})
$('#cor2').change(function(){
		$('#cor_seg').val($(this).val())
	})
</script>