<link rel="stylesheet" href="include/css/paginacao.css">

<div id="paginacao">
	<div id="paginacao-links">

	<?php
	
	$inc = 1;

	
	$inc = 0;
	$GET = $_GET;
	$PAR = $GET['url'].'?';
	foreach($GET as $k=>$v){
		if(substr_count($k, 'pg') or substr_count($k, 'url')){
			continue;
		}elseif($inc<1){
			$PAR .= "$k=$v";
			$inc++;
		}else{
			$PAR .= "&amp;$k=$v";
		}
	}
	
	if($PAR != ''){
		$link = "$PAR".($inc>0 ? '&amp;':'');
	}
	
    $quant_pg = ceil($quantreg/$numreg);
    $quant_pg++;
    
    // BOTÃO ANTERIOR
	echo "<a href='".$link."pg=".($_REQUEST['pg']-1) ."' class=\"".($_REQUEST['pg'] > 0? 'pg': 'pg_off')." nav before\"> &laquo; </a>";
    
    $PAG = $_REQUEST['pg']+1;

	$quant_lk = 10;

	if($PAG>5){
        echo "<a href=".$link."pg=0 class=\"pg\"> 1 </a>
        	  <a href=\"javascript:void(0);\" class=\"pg_off\"> ... </a>";
	}
    for ($i_pg=$PAG-4; $i_pg < $PAG; $i_pg++) {
    	if($i_pg>0){
	        echo "<a href=".$link."pg=".($i_pg-1)." class='pg'> $i_pg </a>";		

    	}
    }
    echo "<a href=\"javascript:void(0);\" class=\"pg_off\"> $PAG </a>";		
   
    for ($i_pg=$PAG+1; $i_pg <= $PAG+6; $i_pg++) {
    	if($i_pg< $quant_pg){
	        echo "<a href=".$link."pg=".($i_pg-1)." class=\"pg\"> $i_pg </a>";		

    	}
    }
    
 	if($PAG<$quant_pg-7){
        echo "<a href=\"javascript:void(0);\" class='pg_off'> ... </a>
        	  <a href=".$link."pg=".($quant_pg-2)." class=\"pg\"> ".($quant_pg-1)." </a>";

	}
   
    
    
    // BOTÃO PRÓXIMO
	echo "<a href=".$link."pg=".($_REQUEST['pg']+1)." class=\"".(($_REQUEST['pg']+2) < $quant_pg? 'pg': 'pg_off')." nav after\"> &raquo;</b></a>";
        
    ?>
    
    </div>
</div>