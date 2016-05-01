<?php
//var_dump(gd_info());

header ("Content-type: image/jpeg");
$im = ImageCreate(100, 200);
$background_color = ImageColorAllocate($im, 234, 234, 234);
$text_color = ImageColorAllocate ($im, 233, 14, 91);
 imageline ($im,0,0,50,100,$text_color)	;
 imageline ($im,0,0,100,100,$text_color);
 imageline ($im,100,0,0,200,$text_color);
 imageline ($im,0,0,100,200,$text_color);
 imageline ($im,$x1,$y1,$x2,$y2,$text_color);
Imagejpeg($im); 

?>
