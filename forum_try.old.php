<?php
require 'auth.php';
require 'lib.php';
require 'head.php';
require 'header_foot.php';
require 'javascript.php';
require 'javascript_forum.php';


echo "<img src='forum.gif'>";

echo "<p><h2><font color=brown>The Forum!</font></h2></p>\n";
echo "<table valign=top><tr><td>";
echo "<div id=forum>";
echo "<ul id='par_0'>";
//echo "<li>";
connect_to_database();
function load_thread($thread_id,$flag){

if ($flag){
	$query="SELECT id, thread, player_name, player_id, title,
content,unix_timestamp(last_mod) as untime FROM forum1 WHERE thread=$thread_id ORDER BY id DESC";
}
else { 
	$query="SELECT id, thread, player_name, player_id, title,
content,unix_timestamp(last_mod) as untime FROM forum1 WHERE thread<>$thread_id ORDER BY id";
}
$res=mysql_query($query);

echo "<script type='text/javascript'>\n";
while($row=mysql_fetch_array($res,MYSQL_ASSOC)){

	if(!$row['player_name']){
		$p=mysql_query("SELECT first_name FROM users WHERE id='".($row['player_id'])."'");
		$player_name=mysql_result($p,0,'first_name');
	}
	/*if(!$row['thread']){
		$
	}*/
	else $player_name=$row['player_name'];
	$content=str_replace("\n","\n",$row['content']);
	$content=str_replace("\r","\\",$content);
	echo "insert_new_post('".$row['id']."','".$row['thread']."',\"".$player_name."\",\"".$row['title']."\",\"$content\",\"".date('F dS g:i a',$row['untime'])."\");\n";
	

}
echo "</script>\n";


}
load_thread(0,0);
load_thread(0,1);
/*$query="SELECT id, thread, player_name, player_id, title,
content,unix_timestamp(last_mod) as untime FROM forum1 ORDER BY id DESC,thread ASC ";
$res=mysql_query($query);

echo "<script type='text/javascript'>\n";
while($row=mysql_fetch_array($res,MYSQL_ASSOC)){

	if(!$row['player_name']){
		$p=mysql_query("SELECT first_name FROM users WHERE id='".($row['player_id'])."'");
		$player_name=mysql_result($p,0,'first_name');
	}
	else $player_name=$row['player_name'];
	$content=str_replace("\n","\n",$row['content']);
	$content=str_replace("\r","\\",$content);
	echo "insert_new_post('".$row['id']."','".$row['thread']."',\"".$player_name."\",\"".$row['title']."\",\"$content\",\"".date('F dS g:i a',$row['untime'])."\");\n";
	

}
echo "</script>\n";*/
echo "</ul>";
echo "</div>";
echo "</table>";
// end of new stuff

require 'footer.php';
?>
