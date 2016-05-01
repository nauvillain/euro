<?php
require 'php_header.php';
require 'javascript.php';

//we need to make sure that we can show the winner & top_scorer
//require 'auth_bets2.php';
//echo "<div id='rankings'>";
$id= $_REQUEST['id'];
connect_to_eurodb();
	echo "<div id='main'>";
	echo "<a href='javascript:back()'>back</a>\n";
//echo "<div id='display_greetings'><a href='player_profile_print.php?id=$id' target='content'>Printable version</a></div>";

//see whether the id is valid ; if player, display it.
$query="SELECT * FROM users
WHERE id='$id'";
//echo $query;

$result=mysql_query($query) or die(mysql_error());
$num=mysql_num_rows($result);

$player=mysql_result($result,0,"player");

if($player==1){

// get player profile

	$first_name=mysql_result($result,0,"first_name");
	$last_name=mysql_result($result,0,"last_name");
	$nickname=mysql_result($result,0,"nickname");

//take the top_scorer name and final winner

	$top=mysql_query("SELECT winner,top_scorer FROM users WHERE
			id='$id'") or die(mysql_error());
	$winner_id=mysql_result($top,0,'winner');
	$scorer_id=mysql_result($top,0,'top_scorer');
	if ($top) {
		$winn=mysql_query("SELECT team_name FROM teams WHERE team_id='$winner_id'");
		$winner=mysql_result($winn,0);
		$tp=mysql_query("SELECT name FROM players WHERE id='$scorer_id'");
		$scorer=mysql_result($tp,0);
}
	if(!$winner_id) $winner="None chosen";

//display the profile

	echo "<table>\n
		<tr>
		  <td>
			<table class='profile_data'>
				<tr>
					<td><font color=green>";
						echo "<b>".$first_name." ".$last_name."</b></font>\n
					</td>
					<td>";
						if ($nickname){echo "...alias <b>".$nickname."</b><br><br>
					</td>
				</tr>\n";}
				if((!still_time(1))||($id==$login_id)) {
				echo "<tr>
				<td><b>Euro Winner:</b></td><td><b> ".strtoupper($winner)."</b></td>
				</tr>";
				echo "<tr>
					<td><b>Top scorer:</td><td> ".$scorer."</b></td>
				</tr>";
				
				$hist=display_bet_history($id);	
				foreach($hist as $row){
						echo "<tr>";
						echo "<td>";
						echo $row['t1']." - ".$row['t2']." </td><td> ".$row['res']." (".($row['$res']?"":$row['pick']).") </td><td> ".f_bet_result($row['res']);
						echo "</td>";
						echo "</tr>";
					}
				
				}
			echo "</table>
		  </td>
		  <td>";
			if(file_exists('photos/'.$id.'.jpg')) echo "<img src=photos/$id.jpg height=160 >";
			else echo "<a href='mailto:vilnico@gmail.com'>Send me</a> your photo! Format: 160px height preferably, in jpg format.";
		  echo "</td>
		 </tr>
		</table>";
	if((!still_time(1))||($id==$login_id)) {

	echo "<table width=95% border=0 cellspacing=0 cellpadding=0>";

	echo "<tr>\n";
	echo "</tr>\n";
	echo "</table>\n";
	}

	}
else echo "This id is not a player's id.";
?>
<?php
require 'foot_foot.php';
?>
