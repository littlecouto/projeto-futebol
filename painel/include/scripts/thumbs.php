<?php
if(substr($imagem,-3)=="gif") {
 header("Content-type: image/gif");
    $im = imagecreatefromgif($_GET['imagem']);
	$wid = (int)$_GET["w"];
	$hei = (int)$_GET["h"];
	$w = imagesx($im);
	$h = imagesy($im);
	  $w1 = $w / $wid;
	  if ($hei == 0)
	  {
	    $h1 = $w1;
		$hei = $h / $w1;
	  }
	  else
	  {
    $h1 = $h / $hei;
      }
	  $min = min($w1,$h1);  
      $xt = $min * $wid;
	  $x1 = ($w - $xt) / 2;
	  $x2 = $w - $x1;	  
      $yt = $min * $hei;
	  $y1 = ($h - $yt) / 2;
	  $y2 = $h - $y1;	  
	$x1 = (int) $x1;
	$x2 = (int) $x2;
	$y1 = (int) $y1;
	$y2 = (int) $y2;				
	$im2 = imagecreatetruecolor($wid,$hei);
    $img = NULL;
    $img = imagecreatetruecolor($wid, $hei); 
    imagecolorallocate($img,255,255,255); 
    $c  = imagecolorallocate($img,255,255,255); 
    $c1 = imagecolorallocate($img,0,0,0); 
	for ($i=0;$i<=$hei;$i++)
	{
	  imageline($img,0,$i,$wid,$i,$c);
	}
	imagecopyresampled($img,$im,0,0,$x1,$y1,$wid,$hei,$x2-$x1,$y2-$y1);	
    imagegif($img);
	} else {
	header("Content-type: image/jpeg");
    $im       = imagecreatefromjpeg($_GET['imagem']);
	$wid = (int)$_GET["w"];
	$hei = (int)$_GET["h"];
	$w = imagesx($im);
	$h = imagesy($im);
	  $w1 = $w / $wid;
	  if ($hei == 0)
	  {
	    $h1 = $w1;
		$hei = $h / $w1;
	  }
	  else
	  {
	    $h1 = $h / $hei;
      }
	  $min = min($w1,$h1);  
      $xt = $min * $wid;
	  $x1 = ($w - $xt) / 2;
	  $x2 = $w - $x1;	  
      $yt = $min * $hei;
	  $y1 = ($h - $yt) / 2;
	  $y2 = $h - $y1;	  
	$x1 = (int) $x1;
	$x2 = (int) $x2;
	$y1 = (int) $y1;
	$y2 = (int) $y2;				
    $img = NULL;
    $img = imagecreatetruecolor($wid, $hei); 
    imagecolorallocate($img,255,255,255); 
    $c  = imagecolorallocate($img,255,255,255); 
    $c1 = imagecolorallocate($img,0,0,0); 
	for ($i=0;$i<=$hei;$i++)
	{
	  imageline($img,0,$i,$wid,$i,$c);
	}
	imagecopyresampled($img,$im,0,0,$x1,$y1,$wid,$hei,$x2-$x1,$y2-$y1);	
    imagejpeg($img);
	}
?>