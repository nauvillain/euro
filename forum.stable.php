<?php
require 'auth_foot.php';
require 'lib/lib_gen.php';
require 'head.php';
require 'header_foot.php';
require 'javascript.php';
require 'javascript_form.php';



echo "<img src='forum.gif'>";

echo "<p><h2><font color=brown>The Forum!</font></h2></p>\n";

echo "<p><font size=2><a
   href='#'
   onClick='javascript:openwin(\"post.php\",600,400)'>Post
   a new message<a></font></p>";

connect_to_eurodb();

//count the total number of posts

$query="SELECT count(*) FROM forum";
$sql=mysql_query($query) or mysql_die();
$total_number=mysql_result($sql,0);

echo "<table width=95% border=0 cellspacing=0 cellpadding=0><tr><td
align left><b><i>".$total_number." posts so far</i></b></td>";
echo "<td align=right><i>\"Goals are important. So are posts.\" </i></td></tr></table>";

echo "<table width=80% border=0 cellspacing=0 cellpadding=0>\n";
echo "<tr><td><a href='forum.php?method=all'> View all messages </a></td></tr>\n";
echo "<tr><td><a href='forum.php?method=thread&show=yes'> View messages by thread </a></td></tr>\n";
echo "</table>";

$cs="";


$method=$_REQUEST['method'];


//show all threads if user selects 'View messages by thread'

if($method=='thread'){

	$thread_id=$_REQUEST['thread_id'];
	$cs=" WHERE thread='$thread_id' OR id='$thread_id'";
	
	$show=$_REQUEST['show'];
	
	if($show=='yes'){
		echo "<table width=80% border=0 cellspacing=0 cellpadding=0>\n";
	
		echo "<tr><td><br><b>Recent threads</b></td></tr>";	
		$quer="SELECT id,title FROM forum WHERE thread='' ORDER BY id DESC";
		$sql=mysql_query($quer) or mysql_die();
		$tot=mysql_num_rows($sql);
		$tot=min($tot,5);
		for($i=0;$i<$tot;$i++){
			$thread_name=mysql_result($sql,$i,'title');
			$id=mysql_result($sql,$i,'id');
			//count how many messages per thread
			$coueri="SELECT count(*) FROM forum WHERE thread='$id'";
			$escuel=mysql_query($coueri) or mysql_die();
			$count=mysql_result($escuel,0)+1;
			if($count>1) $message="messages";
			else $message="message";
		
			echo "<tr><td><font size=1><li><a
	href='forum.php?method=thread&thread_id=".$id."&screen=0'>".$thread_name."</a>
	(".$count." ".$message.")</font></td></tr>\n";
		    }
		echo "<tr><td><p>...<a href='threads.php'>All threads</a></p></td></tr>";
		echo "</table>";
	}
	
}


$string .= "method=".$method."&";
$string .= "thread_id=".$thread_id."&";

if($show!='yes') echo "<a href='forum.php?".$string."show=yes'> Show all threads </a><br>";
else echo "<a href='forum.php?".$string."show=no'> Hide threads </a><br>";

$string .= "show=".$show."&";


//define page variables, such as the number of posts per page;

$screen=$_REQUEST['screen'];


$rows_per_page=18;

if(!isset($screen)) $screen=0;
$start=$screen * $rows_per_page;



if (!$thread_id) $sort_threads="DESC";
else $sort_threads="ASC";

$query="SELECT id, thread, player_id, title,
content,unix_timestamp(last_mod) as untime FROM forum".$cs." ORDER BY
last_mod $sort_threads";

$query1=$query." LIMIT $start,$rows_per_page";
$rez=mysql_query($query) or mysql_die();
//echo $query1;
$for=mysql_query($query1) or mysql_die();
$num_messages=mysql_num_rows($for);

$string='forum.php?';

$total=mysql_numrows($rez);
$pages = ceil($total / $rows_per_page);
mysql_free_result($rez);

if ($screen > 0) {
  $url = $string."screen=" .($screen - 1);
  echo "<a href=\"$url\">Previous</a>\n";
}
// page numbering links now
for ($i = 0; $i < $pages; $i++) {
  $url = $string."screen=".$i;
  echo " | <a href=\"$url\">$i</a> | ";
}
if ($screen < $pages-1) {
  $url = $string."screen=".($screen+1);
  echo "<a href=\"$url\">Next</a>\n";
}

$string .= "screen=".$screen;

echo "<table width=90% border=0 cellspacing=0 cellpadding=0>";

for($i=0;$i<$num_messages;$i++){

   $id=mysql_result($for,$i,'id');
   $thread=mysql_result($for,$i,'thread');

   if ($thread) {
      $tmp=mysql_query("SELECT title FROM forum WHERE id='$thread'") or mysql_die();
      $title=mysql_result($tmp,0);
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

   $text=str_replace("\n","<br>",$text);
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
   align=left><font size=1><b><a href='player_profile.php?id=$pl'>".$player."</a></font></b></td>\n";
   echo "<td <font size=1><a
   href='forum.php?method=thread&thread_id=".$thread."&show=no'>View all
   posts on this thread<a></font></td>";
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

echo "<form name='form_post' method='post' action='new_post.phpxonsubmit='javascript:return newPost(this)'>";

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
