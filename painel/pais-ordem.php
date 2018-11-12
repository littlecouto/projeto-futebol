<link rel="stylesheet" type="text/css" href="include/js/jquery-ui.css">
<div class="formulario">
<style>
.ordenavel {
    list-style-type: none;
    margin: 0;
    padding: 5px;
    width: 930px;
    float: left;
	display: table;
}
ul.ordenavel.importante {
    margin-bottom: 50px;
    border: 1px solid #BBB;
}
.ordenavel li {
    margin: 3px 3px 3px 0;
    float: left;
    width: 100px;
    height: 50px;
    font-size: 11px;
    text-align: center;
    box-sizing: border-box;
    padding: 3px;
}
.ordenavel li:hover {
	border-color: #000;
	background-color: #BBB;
	color: #FFF;
}
.ordenavel li:active {
	box-shadow: 0px 0px 5px #063;
	border-color: #063;
}
</style>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="ACAO" value="ADICIONAR" />
	<div class="area">
    
	<h2>IMPORTANTES</h2>
    <ul class="ordenavel importante conecta">
		
        <?php
        
			$resPai = mysql_query("SELECT idPai, titulo, ordem FROM pais WHERE importante=1 ORDER BY ordem") or die(mysql_error());
			
			while($rowPai = mysql_fetch_array($resPai)){
				echo "<li class=\"ui-state-default\" id=\"$rowPai[idPai]\">$rowPai[titulo]</li>";
			}
		?>    
    
    </ul>
	
    <h2>OUTROS</h2>
    <ul class="ordenavel outros conecta">
		
        <?php
        
			$resPai = mysql_query("SELECT idPai, titulo, ordem FROM pais WHERE importante=0 ORDER BY ordem") or die(mysql_error());
			
			while($rowPai = mysql_fetch_array($resPai)){
				echo "<li class=\"ui-state-default\" id=\"$rowPai[idPai]\">$rowPai[titulo]</li>";
			}
		?>    
    
    </ul>
         
        
    </form>
    
    <script src="include/js/jquery-ui.js"></script>
	<script>
		$(function() {
			$( ".ordenavel" ).sortable({
				placeholder: "ui-state-highlight",
				connectWith: ".conecta",
				update: function (event, ui) {
					var importantes = jQuery('.ordenavel.importante li').map(function(){
						return 'item[]=' + this.id.match(/(\d+)$/)[1]
					}).get()
					importantes = importantes.join('&');

					var outros = jQuery('.ordenavel.outros li').map(function(){
						return 'item[]=' + this.id.match(/(\d+)$/)[1]
					}).get()
					outros = outros.join('&');
					
					
					
					// POST to server using $.post or $.ajax
					$.post('pais-ordem-ajax?i=1',importantes);
					$.post('pais-ordem-ajax?i=0',outros);
				},
				receive: function(event, ui) {
					// so if > 10
					if ($(this).children().length > 32 && $(this).hasClass('importante')) {
						//ui.sender: will cancel the change.
						//Useful in the 'receive' callback.
						$(ui.sender).sortable('cancel');
					}
				}
			}).disableSelection();
		});
    </script>
</div>