<?php
	
	function resampimagejpg( $forcedwidth, $forcedheight, $sourcefile, $destfile )
{
$fw = $forcedwidth;
$fh = $forcedheight;
$is = getimagesize( $sourcefile );
if( $is[0] >= $is[1] ) {
$orientation = 0;
}
else {
	$orientation = 1;
	$fw = $forcedheight;
	$fh = $forcedwidth;
}
if ( $is[0] > $fw || $is[1] > $fh ) {
	if( ( $is[0] - $fw ) >= ( $is[1] - $fh ) ){
		$iw = $fw;
		$ih = ( $fw / $is[0] ) * $is[1];
}
else {
	$ih = $fh;
	$iw = ( $ih / $is[1] ) * $is[0];
}
$t = 1;
}
else {
$iw = $is[0];
$ih = $is[1];
$t = 2;
}
if ( $t == 1 ) {
$img_src = imagecreatefromjpeg( $sourcefile );
$img_dst = imagecreatetruecolor( $iw, $ih );
imagecopyresampled( $img_dst, $img_src, 0, 0, 0, 0, $iw, $ih, $is[0], $is[1] );
if( !imagejpeg( $img_dst, $destfile, 90 ) ) {
exit( );
}
}
else if ( $t == 2 ) {
copy( $sourcefile, $destfile );
}
}

function draw_evolution($id1,$id2){

$sql=mysql_query("SELECT * FROM matches WHERE played=1");
while($nt=mysql_fetch_array($sql)){
	//$pts1=	
}
}
?>

