<?php
require 'php_header.php';


$p=$_GET['p'];



connect_to_eurodb();

echo "<div id='main'>";

$sql_query="SELECT * FROM bets WHERE player_id='$p' order by match_id" ;


$res=mysql_query($sql_query);
$num=mysql_num_rows($res) or die(mysql_error());

echo $num."<br/>";
while($row=mysql_fetch_array($res)){
	echo $row['player_id']."-".$row['match_id'].":".$row['pick'].",".$row['weight']."<br/>";
}

?>
<?php
require 'foot_foot.php';
?>
