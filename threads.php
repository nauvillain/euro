<?php
require 'auth.php';
require 'lib.php';
require 'head.php';
require 'header_foot.php';
require 'javascript.php';
require 'javascript_form.php';



echo "<img src='forum.gif'>";

echo "<p><h2><font color=brown>The Forum!</font></h2></p>\n";

echo "<h3> All threads</h3>";
connect_to_database();

//count the total number of posts



$cs="";





	$thread_id=$_REQUEST['thread_id'];
	$cs=" WHERE thread='$thread_id' OR id='$thread_id'";
	
	
		echo "<table width=80% border=0 cellspacing=0 cellpadding=0>\n";
	
	
		$quer="SELECT id,title FROM forum WHERE thread='' ORDER BY id DESC";
		$sql=mysql_query($quer) or mysql_die();
		$tot=mysql_num_rows($sql);
		echo "<tr><td><table>";
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
		 $items++;
		 if($items==round($tot/2)+1){
			echo "</table></td><td valign=top><table>";	
		}   
			}
		    echo "</table>";
	
require 'footer.php';
?>
