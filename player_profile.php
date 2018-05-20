<?php
require 'php_header.php';
require 'javascript.php';
css('player_profile.css');
function display_contact_chain($id,$login_id){
	if($id!=$login_id) {
		$k=0;
		$contact=contact_chain($id,$login_id);
		while(list($val,$key)=each($contact)){
			if($k) echo "->";
			if(is_array($key)){
				while(list($val1,$key1)=each($key)){
					if($j) echo "->";
					echo $key1;
					$j=1;
				}
			}
			else echo $key;
			$k=1;
		}
	}
}
//we need to make sure that we can show the winner & top_scorer
//require 'auth_bets2.php';
//echo "<div id='rankings'>";
$id= $_REQUEST['id'];

if(!isset($scorer)) $scorer="";
connect_to_eurodb();
	echo "<div id='foot_main'>";
	if($id==$login_id) echo "<a href='edit_profile.php'>Edit</a>\n";
	//else echo "<a href='javascript:history.back()'>back</a>\n";
//echo "<div id='display_greetings'><a href='player_profile_print.php?id=$id' target='content'>Printable version</a></div>";

//see whether the id is valid ; if player, display it.
$query="SELECT * FROM users
WHERE id='$id'";
//echo $query;

$result=mysqli_query($link,$query) or die(mysql_error());
$num=mysqli_num_rows($result);

$player=mysqli_result($result,0,"player");

$group=mysqli_query($link,"SELECT id FROM usergroups WHERE user_id='$id'");
$has_group=mysqli_num_rows($group);
echo "<div id='graph_link'>\n";
	echo "<a href='point_history.php?".graph_link($id,1)."'>Point graph</a>&nbsp;\n";
	if($has_group) echo "<a href='point_history.php?group=".$id."&".graph_link($id,0)."'>Point graph(group)</a>\n";
	if($id==$login_id) echo "<a href='set_user_group.php?id=$id'>Set my group</a>&nbsp;\n";
echo "</div>\n";


if($player==1){

// get player profile

	$first_name=mysqli_result($result,0,"first_name");
	$last_name=mysqli_result($result,0,"last_name");
	$nickname=mysqli_result($result,0,"nickname");
	$country=mysqli_result($result,0,"country");
	$city=mysqli_result($result,0,"city");
	$comments=mysqli_result($result,0,"comments");
	$age=mysqli_result($result,0,"age");
	$fav_player=mysqli_result($result,0,"fav_player");
	$fav_team=mysqli_result($result,0,"fav_team");
	$pts=mysqli_result($result,0,"current_points");

//take the top_scorer name and final winner

	$top=mysqli_query($link,"SELECT winner,top_scorer FROM users WHERE
			id='$id'") or die(mysql_error());
	$winner_id=mysqli_result($top,0,'winner');
	$scorer_id=mysqli_result($top,0,'top_scorer');
	if ($top) {
		$winn=mysqli_query($link,"SELECT team_name FROM teams WHERE team_id='$winner_id'");
		if(mysqli_num_rows($winn)) $winner=mysqli_result($winn,0);
		$tp=mysqli_query($link,"SELECT name FROM players WHERE id='$scorer_id'");
		if(mysqli_num_rows($tp)) $scorer=mysqli_result($tp,0);
	}
	if(!$winner_id) $winner="None chosen";

//display the profile

	echo "<table class='profile_results'>\n";
	echo   "<tr>
		  <td>
			<table class='profile_data'>
				<tr>";
		  	echo "<tr><td>\n";
			if(file_exists('photos/'.$id.'.jpg')) {
				echo "<img src='photos/$id.jpg' width=150px;>";
				echo "<br/>\n";
				if($login_id==$id) echo "<a href='upload_image.php'>Change it</a>\n";
			}
			else if ($login_id==$id) echo "<a href='upload_image.php'>Upload your profile picture</a>";
		  echo "</td>\n";
			echo "<td>\n";
			echo "<font color=green>";
			echo "<b>".$first_name." ".$last_name."</b></font>\n";
			if ($nickname)echo "<br/><br/>...alias <b>".$nickname."</b><br><br>";
			echo "</td>";
		echo "</tr>";
					echo "<td>\n";
					echo "</td>
					<td>";
					echo "</td>
				</tr>\n";
					if(!still_time(2)){
						?>
					<tr>
					<td><b><a href='rankings.php' class='no_dec'> Ranking</a></b>	</td><td><b>	<?php echo get_ranking($id); ?></b>	</td></tr>
					<td><b><a href='rankings.php' class='no_dec'> Points</a></b>	</td><td><b>	<?php echo round($pts,2); ?></b>	</td></tr>
				<?php
					}
				echo "<tr>
					<td>
					<b>Location:</td><td>".utf8_encode($city).", ".utf8_encode($country).".</td></tr>\n";
					echo "<tr><td>Age: </td><td>".$age."</td></tr>\n";
					echo "<tr><td>Favourite player: </td><td>".utf8_encode($fav_player)."</td></tr>\n";
					echo "<tr><td>Favourite team: </td><td>".utf8_encode($fav_team)."</td></tr>\n";
					echo "<tr><td>Comments: </td><td>".utf8_encode($comments)."</td></tr>\n";
					echo"<tr><td><a href='display_user_tree.php'>Contact chain</a>:</td><td>";
					display_contact_chain($id,$login_id);
					echo "</td></tr>\n";
				if((!still_time(1))||($id==$login_id)||is_played(1)) {
				echo "<tr>
				<td><b>".get_word_by_id(91)."</b></td><td><b> ".strtoupper($winner)."</b></td>
				</tr>"; //winner
				echo "<tr>
					<td><b>Top scorer:</td><td> ".$scorer."</b></td>
				</tr>";
				}
		  echo "</table>
		  </td>
		 </tr>
		</table>\n";
	if((!still_time(1))||($id==$login_id)||is_played(1)) {

	echo "<table class='profile_data'>";

					$hist=display_bet_history($id);	
					if(sizeof($hist)){
							foreach($hist as $row){
								if(is_played($row['m_id'])){
									echo "<tr>\n";
									echo "<td>\n";
									$index='coef'.pick_to_bet($row['pick']);
									$res=$row['res'];
//									echo $row['t1']." </td><td>-</td><td width='100'> ".$row['t2']." </td><td> ".$arr_pick[$row['pick']]." --- ".($res*$row['weight'])." ".($res?"":"(".$row['weight'].")")." </td><td> ".(is_played($row['m_id'])?f_bet_result($row['res']):"");
									echo $row['t1']." </td><td>-</td><td width='100'> ".$row['t2']." </td>\n";
									echo "<td> ".($row['pick']?$arr_pick[$row['pick']]:"")."  </td>\n";
									$ro=$row['round_id'];
									echo "<td> ".(is_played($row['m_id'])?f_bet_result($row['res']):"")."</td>\n";
									echo "<td> ".($row['res']?cap_odds(round($row[$index]*$coef_round[$ro],2)):"")."  </td>\n";
									
									echo "</tr>\n";
								}
							}
			
						}
					}
	echo "</table>\n";
	}
	
else echo "This id is not a player's id.";
?>

</div>

<?php

?>
