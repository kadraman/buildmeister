<?php
header ("Content-type: image/gif");
$text = base64_decode ($_GET['imgtxt']);
$image = imagecreate (100,20);
$black = imagecolorallocate ( $image, 255,255,255 );
$x = rand(1,8);
$yellow = imagecolorallocate ( $image, 20,20,20 );
imagestring ($image, 6, (8*$x), $x, $text , $yellow ); 
imagegif ($image);
?>