<?php
include 'xml.class.php';

$item=get_rss_items('http://www.scorespro.com/rss/live-soccer.xml');
foreach ($item as $key=>$val) {
	$arr= new xmlScore($val);
var_dump($arr);
echo '<br/>';
}
?>
