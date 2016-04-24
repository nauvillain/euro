<?php
require 'authAdm.php';
require 'lib.php';
require 'head.php';
require 'headerAdm.php';
require 'javascript.php';
require 'javascript_form.php';


echo "<TITLE>Forum - Euro 2004</TITLE>";

echo "<p><h2><font color=brown>The Forum!</font></h2></p>\n";

echo "<p><font size=2><a
   href='#'
   onClick='javascript:openwin(\"post.php\",600,400)'>Post
   a new message<a></font></p><br>";
connect_to_database();

$query="SELECT id, thread, player_id, title, content,unix_timestamp(last_mod) as untime FROM forum";
$for=mysql_query($query) or mysql_die();
$num_messages=mysql_num_rows($for);

echo "<table width=90% border=0 cellspacing=0 cellpadding=0>";

for($i=0;$i<$num_messages;$i++){

   $id=mysql_result($for,$i,'id');
   $thread=mysql_result($for,$i,'thread');

   if ($thread) {
      $tmp=mysql_query("SELECT title FROM forum WHERE id='$thread'") or mysql_die();
      if(mysql_num_rows($tmp))$title=mysql_result($tmp,0);
      $title="Re:".$title;
      }
   else    {
	   $thread=$id;
	   $title=mysql_result($for,$i,'title');
	   }
   $pl=mysql_result($for,$i,'player_id');
   $player=get_player_name($pl);
   $text=mysql_result($for,$i,'content');
   $last=mysql_result($for,$i,'untime');
   $dat=date("F dS, g:i a",$last);

   echo "<tr><td>\n";
   echo "<table width=100% border=0 cellspacing=0 cellpadding=0><tr><td>\n";
   echo "       <table width=100% border=0 cellspacing=0
   cellpadding=0><tr><td><i>".$title."</i></td><td align=right><font size=1>\n";
   echo	$dat."</font></td></tr></table>\n</td></tr><tr><td>";
   echo "	<table width=100% border=0 cellspacing=0 cellpadding=0>";
   echo "	       <tr><td>\n";
   echo "	       <table width=100% border=1 cellspacing=0
   cellpadding=0 valign=top><tr><td>";
   echo "	       <table width=100% border=0 cellspacing=0 cellpadding=0><tr><td
   align=left><font size=1><b>".$player."</font></b></td>\n";
   echo "<td><a href=\"javascript:del('deleteMessageAdm.php?id=".$id."')\"> Delete </a></td>";
   echo "	      <td align=right><font size=1><a
   href='#' onClick='javascript:openwin(\"post.php?thread=".$thread."\",600,400)'>Reply to this
   message<a></font></td></tr></table>\n	</td></tr>";
   echo "	<tr><td>".$text."</td></tr>\n";
   echo "</table></tr></td>";
   echo "</table>";
   echo "</table></td></tr>";
   echo "<tr><td><font size=1><a
   href='#'
   onClick='javascript:openwin(\"post.php\",600,400)'>Post
   a new message<a></font></td></tr>";
   
}
/*
echo "</table><br>\n";
echo "<p><h4><font color=brown>Post a new message</font></h4></p>";

echo "<form name='form_post' method='post' action='new_post.php'
onsubmit='javascript:return newPost(this)'>";

echo "<table border=0>";
echo "<tr>\n";
echo "<td><table border=0><tr><td valign='top'>Title:</td>\n";
echo "<td><input name='title' type='text' id='title' value=''
size=40></td>\n";
echo "</tr></table></td></tr>\n";
echo "<tr><td> Message </td></tr>";
echo "<tr><td><textarea name='content' rows=10 cols=70 id='content'
wrap='virtual'></textarea></td>";
echo "</tr>\n";
echo "</table>";
echo "<table>";
echo "<tr>\n";
echo "<td></td><td><input type='button' value='Cancel'
      onClick='javascript:history.back()'>&nbsp;&nbsp;&nbsp;</td>\n";
echo "<td><input type='submit' name='Submit' value='Submit' ></td>
    </tr>\n";
echo "</table>\n";*/

require 'footer.php';
?>
