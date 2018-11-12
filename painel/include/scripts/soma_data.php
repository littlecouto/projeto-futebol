<?php

function somadata($data, $dias){ //função para gerar data final

     return date('Y-m-d', strtotime($data. " + $dias days"));

}


?>