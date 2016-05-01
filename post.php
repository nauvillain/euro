<?php
require 'auth.php';
require 'config/config_foot.php';
require 'conf.php';
require 'lib_foot.php';

require 'javascript.php';
?>
<script language="JavaScript">
<!--
function repPost(theForm)
{
	if(theForm.content.value=="")
	{
		alert('Your message is empty!');
		return false;
	}	   
	return true; 
}

//-->
</script>
<?php
echo "<TITLE>New post - Euro 2004</TITLE>";

$thread= $_REQUEST['thread'];

echo "<p><h4><font color=brown>Post your message:</font></h4></p>";

echo "<form name='form_post' method='post' action='rep_post.php'
onsubmit='javascript:return repPost(this)'>";

echo "<table border=0>";
if(!$thread){
echo "<tr>\n";
echo "<td><table border=0><tr><td valign='top'>Title:</td>\n";
echo "<td><input name='title' type='text' id='title' value=''
size=40></td>\n";
echo "</tr></table></td></tr>\n";
}
else {
echo "<tr>\n";
echo "<td><table border=0><tr><td valign='top'>Re:</td>\n";
connect_to_database();
$tmp=mysql_query("SELECT title FROM forum WHERE id='$thread'") or
mysql_die();
$title=mysql_result($tmp,0);
echo "<td>".$title."<td><tr>";
echo "</tr></table></td></tr>\n";
}
echo "<tr><td><textarea name='content' rows=10 cols=70 id='content'
wrap='virtual'></textarea></td>";
echo "</tr>\n";
echo "<tr><td><input name='thread' type=hidden id='thread'
value=$thread></td>";
echo "</tr>\n";
echo "</table>";
echo "<table>";
echo "<tr>\n";
echo "<td></td><td><input type='button' value='Cancel'
      onClick='javascript:window.close()'>&nbsp;&nbsp;&nbsp;</td>\n";
echo "<td><input type='submit' name='Submit' value='Submit' ></td>
    </tr>\n";
echo "</table>\n";
?>
