<?php
require 'auth_foot.php';
//global vars
require 'config/config_foot.php';
require_once 'conf.php';
//general library functions
require 'lib/lib_gen.php';
require 'lib_foot.php';

require 'lib/lib_forum.php';

//$temp=$_GET['text'];
//$temp = preg_replace("/(http:\/\/[^\s]+)/","<a href=\"$1\">$1</a>",$temp);


$content=htmlspecialchars($_GET['text'],ENT_NOQUOTES,'UTF-8');
//$content=htmlspecialchars($temp,ENT_NOQUOTES,'UTF-8');
$content = preg_replace("/(http:\/\/[^\s]+)/","<a href='$1' target='new'>$1</a>",$content);
$content=str_replace("\n","<br/>",$content);
$content=str_replace("\n","<br/>",$content);
$content=str_replace("\r","\\",$content);
$content=str_replace('"',"''",$content);
$content=str_replace('+',"\+",$content);
$content=str_replace('-',"\-",$content);
//$content=urltolink($content);

$title=htmlspecialchars($_GET['title']);
$div=$_GET['id'];
$content=str_replace("%u2013","-",$content);
//$content=htmlspecialchars($content,ENT_NOQUOTES,'UTF-8');
$title=str_replace("%u2013","-",$title);

?>
<?php
$ids=explode("_",$div);
$id=$ids[1];
$t_id=$ids[0];
if(!$id) $content="[".date("M d, h:m")."] - ".$content;
//echo "id=$id<br>";
//echo "t_id=$t_id";

connect_to_eurodb();
//$content=substr($content,0,-4);
$username=get_username($login_id);
$nick=get_nick($login_id);
sqlutf();
mysql_query("INSERT INTO forum SET thread='$id',user_id='$login_id',user_name='$username',user_nick=\"".$nick."\",content=\"".$content."\"".($title?",title=\"".$title."\"":"")) or die(mysql_error());
update_thread_timestamp($id);
echo "The following reply has been posted:".$content ;
?>
