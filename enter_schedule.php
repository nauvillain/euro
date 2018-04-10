<?php
require 'php_header.php';
echo "<script type='text/javascript' src='js/javascript_bets.js'>\n";
echo "</script>\n";

connect_to_eurodb();
$res=mysqli_query($link,"SELECT * FROM matches ORDER BY id");
$num_first=mysqli_num_rows($res);

$id=getIfSet($_REQUEST['id']);
$last_id=getIfSet($_REQUEST['last_id']);
if((!$id)&&($last_id)) {
	$id=$last_id+1;
	$use_old_date=1;
}
else $use_old_date=0;
if(!$last_id) $last_id=$id;

$last_res=mysqli_query($link,"SELECT * FROM matches WHERE id='".$last_id."'");
$last_match=mysqli_fetch_array($last_res,MYSQLI_ASSOC);

$edit_res=mysqli_query($link,"SELECT * FROM matches WHERE id='".$id."'");
$current_match=mysqli_fetch_array($edit_res,MYSQLI_ASSOC);

echo "<div id='foot_main'>";
?>
<!--[if IE]> <p>You are using Internet Explorer: please be careful not to go below the average of 1 point per remaining match, as the page is buggy then. I am working on fixing it. Please use Firefox for more stability.</p> <![endif]--> 
<?php
//echo "<div id='sa_menu_title' style='top:-30px;left:278px;'><img src='img/picks.gif'/></div>\n";

//see what has been already entered by the user

//take matches that correspond to the first round

$res=mysqli_query($link,"SELECT * FROM matches ORDER BY id");
$num_first=mysqli_num_rows($res);
function drop_down_team($team,$flag){
	global $link;
	$res=mysqli_query($link,"SELECT team_id,team_name from teams ORDER by team_name") or die(mysqli_error($link));
	$num=mysqli_num_rows($res);

	$team_number='team'.$flag;

	echo "<select name='".$team_number."'>\n";
	for ($i=0;$i<$num;$i++){
		$team_id=mysqli_result($res,$i,'team_id');
		$team_name=mysqli_result($res,$i,'team_name');
		echo "<option  value='$team_id' ".($team_id==$team?"selected":"").">".get_team_name($team_id)."</option>\n";
	}
	echo "</select>\n";
}
function drop_down_id($last_id){
	global $link;
	$res=mysqli_query($link,"SELECT id from matches ORDER by id") or die(mysqli_error($link));
	$num=mysqli_num_rows($res);


	echo "<select name='id'>\n";
	for ($i=0;$i<$num;$i++){
		$id=mysqli_result($res,$i,'id');
		echo "<option  value='$id' ".($id==$last_id?"selected":"").">".$id."</option>\n";
	}
	echo "</select>\n";
}
function drop_down_place($p_id){
	global $link;
	$res=mysqli_query($link,"SELECT place_id,stadium from places ORDER by place_id") or die(mysqli_error($link));
	$num=mysqli_num_rows($res);


	echo "<select name='place_id'>\n";
	for ($i=0;$i<$num;$i++){
		$id=mysqli_result($res,$i,'place_id');
		$stadium=mysqli_result($res,$i,'stadium');
		echo "<option  value='$id' ".($id==$p_id?"selected":"").">".$stadium."</option>\n";
	}
	echo "</select>\n";
}

//check if player has entered any bets
//if he has but hasn't entered them all
//take the top scorer & World Cup Winner

if($use_old_date)	$date_value=$last_match['date'];
else $date_value=$current_match['date'];

echo "<div id='display_greetings'><a href='javascript:history.back()'> Back</a></div>";
$top=mysqli_query($link,"SELECT winner,top_scorer FROM users WHERE
id='$login_id'") or die(mysqli_error($link)());
if(mysqli_num_rows($top))  $winner_id=mysqli_result($top,0,'winner');
if (mysqli_num_rows($top)) {
	$query="SELECT team_name FROM teams WHERE team_id='$winner_id'";
//	echo $query;
	$winn=mysqli_query($link,$query) or die(mysqli_error($link));
	if(mysqli_num_rows($winn)) $winner=mysqli_result($winn,0,'team_name');
	}
if(!$winner_id) $winner="None chosen yet";
//find top_scorer
$top_sc=mysqli_result($top,0,'top_scorer');
echo "Last game: ID:".$last_match['id']." - ".$last_match['date']." - ".$last_match['time']." - ".get_team_name($last_match['t1'])." - ".get_team_name($last_match['t2'])." - ".$last_match['descr']."    <a href=\"enter_schedule.php?id=".$last_id."\">edit</a>";
echo "<p>Enter next match</p>";
echo "<form name='form1' method='post' onsubmit=\"javascript:return checkForm(this)\"  action='submit_match_schedule.php' >\n";
        drop_down_id($id);
	echo "<input type='date' value='".$date_value."' name='match_date'>";	
	echo "<input type='time' value='".$current_match['time']."' name='match_time'>";	
	drop_down_team($current_match['t1'],1);
	drop_down_team($current_match['t2'],2);	
	drop_down_place($current_match['place']);
	echo "<span>".$current_match['descr']."</span>";
	echo "<input type='submit' name='Submit' value='Submit'>\n";
	echo "</form>\n";
	echo "<br/>\n";
	echo "<table align='center'>\n";
	while($row=mysqli_fetch_array($res)){
		echo "<tr>\n";
		echo "<td>\n";
		echo $row['id'];
		echo "</td>\n";
		echo "<td>\n";
		echo get_team_name($row['t1']);
		echo "</td>\n";
		echo "<td>\n";
		echo " - ";
		echo "</td>\n";
		echo "<td>\n";
		echo get_team_name($row['t2']);
		echo "</td>\n";
		echo "<td>\n";
		echo $row['date'];
		echo "</td>\n";
		echo "<td>\n";
		echo $row['time'];
		echo "</td>\n";
		echo "<td>\n";
		echo "<a href='enter_schedule.php?id=".$row['id']."'>".$row['id']."</a>\n";
		echo "</td>\n";
		echo "</tr>\n";
		
	}
	echo "</table>\n";
?>
