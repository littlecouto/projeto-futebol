<?php

$filename  = $_GET['img'];
$newWidth  = $_GET['w'] == '' ? 0 : $_GET['w'];
$newHeight = $_GET['h'] == '' ? 0 : $_GET['h'];

/*
LI: Largura Original da Imagem
AI: Altura Original da Imagem
NLI: Nova Largura da Imagem
NAI: Nova Altura da Imagem
*/


$dim = getimagesize($filename);

$oldWidth  = $dim[0];
$oldHeight = $dim[1];


function NovaLar($AI, $LI, $NAI){
	return $LI/$AI*$NAI;
}
function NovaAlt ($AI, $LI, $NLI){
	return $AI / $LI * $NLI;
}

function proporcao ($AI, $LI, $NAI=0, $NLI=0){
	if($NAI > 0){
		return NovaLar($AI, $LI, $NAI);
	}elseif($NLI >0){
		return NovaAlt($AI, $LI, $NLI);
	}
	return false;
}

if(!$newWidth and !$newHeight){
	$newWidth  = proporcao($oldHeight, $oldWidth, $newWidth, $newHeight);
	$newHeight = proporcao($oldHeight, $oldWidth, $newWidth, $newHeight);
}

$imageInfo = getimagesize($filename);

$image = imagecreatefrompng($filename); //create source image resource
imagesavealpha($image, true); //saving transparency

$newImg = imagecreatetruecolor($newWidth, $newHeight); //creating conteiner for new image
imagealphablending($newImg, false);
imagesavealpha($newImg,true);
$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127); //seting transparent background
imagefilledrectangle($newImg, 0, 0, $newWidth, $newHeight, $transparent);
imagecopyresampled($newImg, $image, 0, 0, 0, 0, $newWidth, $newHeight,  $imageInfo[0], $imageInfo[1]);

header('Content-Type: image/png');

imagepng($newImg); //printout image string


?>