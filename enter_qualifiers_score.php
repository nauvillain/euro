<?php
require 'php_header.php';
//require 'admin.php';
if(is_admin($login_id)){
	echo "<div id='foot_main'>\n";
	$match_id=getIfSet($_REQUEST['match_id']);
	$team_id=getIfSet($_REQUEST['team_id']);
	echo "<div id='teams_list'>";

	$sql=mysqli_query($link,"SELECT * FROM teams") or mysqli_error($link);
	$num_teams=mysqli_num_rows($sql);
		echo "<div id='team_banner' >";
	echo "<table id='big_table'><tr><td>\n";
	echo "<table class='teams_table'> \n";
	for($i=0;$i<$num_teams;$i++){
		$grp=intval($i/4);
		
		if(($i)%4==0&&$i) echo "</table></td><td><table class='teams_table'>\n";
		echo "<tr><td style='border-bottom: 1px solid black;' >";
		if($i%4==0) echo "<span style='font-weight:800;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$groups[$grp]."</span></td></tr><tr><td style='border-bottom: 1px solid black;' >";
	//	$name=mysqli_result($sql,$i,'team_name');
		$id=mysqli_result($sql,$i,'team_id');
		$name=substr(get_team_name($id),0,23);
		echo "<a href='enter_qualifiers_score.php?team_id=$id'>".$name."</a>\n";
		echo "</td></tr>\n";
		
	}
	echo "</table></td></tr></table>\n";
	echo "</div>\n";
	echo "</div>\n";

	?>
	<div id='team_details' >
	<br/>
	<form name='form1' style='position:absolute;width:1200px;' method='post' onLoad=\"document.getElementById('g1').focus()\"  action='submit_qualifiers_score_adm.php'>

	<?php
		function drop_down($team,$selected){
			global $link;
			$res=mysqli_query($link,"SELECT team_id,team_name from all_teams ORDER by team_name") or mysqli_error($link);
			$num=mysqli_num_rows($res);
			echo "<select name='$team'>\n";
			for ($i=0;$i<$num;$i++){
				$team_id=mysqli_result($res,$i,'team_id');
				$team_name=mysqli_result($res,$i,'team_name');
				echo "<option  value='$team_id'".($team_id==$selected?" selected":"").">".get_all_team_name($team_id)."</option>\n";
			}
			echo "</select>\n";
		}
		
		function get_team_id($team,$match_id){
			global $link;
			$res=mysqli_query($link,"SELECT id,$team from qualifiers WHERE id='$match_id'") or die(mysqli_error($link));
			$num=mysqli_num_rows($res);
			return mysqli_result($res,$team,0);
		}

		if($match_id) {
			$t1=get_team_id('t1',$match_id);
			$t2=get_team_id('t2',$match_id);
		}

		drop_down('t1',$t1);
		echo "<input name='g1' id='g1' size=1>\n";
		echo "<input name='g2' id='g2' size=1>\n";
		drop_down('t2',$t2);
		echo "<input type='hidden' name='last_team' value='$team_id'>\n";
	?>

	<input type=submit name='submit' type='submit' value='submit match'>
	</form>
	<div style='position:absolute;width:1200px;top:40px;height:1000px;' >
<table style='margin:0 auto;background:#e1e1e1;'>

	<?php

	sqlutf();
	if(isset($team_id)){
		$res=mysqli_query($link,"SELECT * FROM qualifiers WHERE t1='$team_id' OR t2='$team_id' ORDER BY id desc ");
		$num=mysqli_num_rows($res);
		//echo $num."<br/>";
		for($i=0;$i<$num;$i++){
			$t1=mysqli_result($res,$i,'t1');
			$g1=mysqli_result($res,$i,'g1');
			$t2=mysqli_result($res,$i,'t2');
			$g2=mysqli_result($res,$i,'g2');
			$team_name1=get_all_team_name($t1);
			$team_name2=get_all_team_name($t2);

			echo "<tr><td>".$team_name1."</td><td>".$g1." - ".$g2."</td><td>".$team_name2."</td><tr/>";
			}
	}
	else {
		$res=mysqli_query($link,"SELECT * FROM qualifiers ORDER BY id DESC");
		$num=mysqli_num_rows($res);
		$max=min($num,10);
		for($i=0;$i<$max;$i++){
			$t1=get_all_team_name(mysqli_result($res,$i,'t1'));
			$t2=get_all_team_name(mysqli_result($res,$i,'t2'));
			$g1=mysqli_result($res,$i,'g1');
			$g2=mysqli_result($res,$i,'g2');
			echo "<tr><td>".$t1."</td><td>".$g1." - ".$g2."</td><td>".$t2."</td><tr/>";
			//echo "$t1 - $g1 : $g2 - $t2 <br/>\n";
			}
	}
	echo "</table>\n";

	echo "</div>\n";
	}
?>
