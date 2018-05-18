<?php
require 'php_header.php';
echo "<script type='text/javascript' src='js/javascript_bets.js'>\n";
echo "</script>\n";
//echo "<no script>Javascript is turned off... please turn it on!\n";
//echo "</noscript>\n";
//require 'auth_bets1.php';
connect_to_eurodb();
$res=mysqli_query($link,"SELECT * FROM matches ORDER BY id");
$num_first=mysqli_num_rows($res);
function display_weight_info($language){
 
		switch($language){
			case 'en':		echo "<td id='total_points' class='middle' COLSPAN='7'> You have used <b id='b_text'></b> points, average:<b id='b_textm'></b> pts/match,<br/><b id='b_textr'></b> pts remaining, <b id='b_textmr'> average:</b> pts/remaining match</td><td>
      		<input type='submit' name='Submit' value='Submit'>
		</td><td></td>\n";
			break;
			case 'fr':
				echo "<td id='total_points' class='middle' COLSPAN='7'> Vous avez utilisé <b id='b_text'></b> points, moyenne:<b id='b_textm'></b> pts/match,<br/>reste <b id='b_textr'></b> pts, <b id='b_textmr'> moyenne:</b> pts/match restant</td><td>
      		<input type='submit' name='Submit' value='Valider'>
		</td><td></td>\n";
			break;
			case 'hu';
				echo "<td id='total_points' class='middle' COLSPAN='7'> <b id='b_text'></b> pontot használtál fel, átlagban:<b id='b_textm'></b> pt/meccs,<br/><b id='b_textr'></b> pt maradt, <b id='b_textmr'> átlagban:</b> pt/hátralevő meccs</td><td>
      		<input type='submit' name='Submit' value='Elküld'>
		</td><td></td>\n";
			break;
		}

}

$bets=mysqli_query($link,"SELECT *  FROM bets WHERE player_id='$login_id' ORDER by match_id ASC") or mysqli_error($link);

$pl=mysqli_query($link,"SELECT id FROM matches WHERE played=1 ORDER BY id");
$num_played=mysqli_num_rows($pl);
$bet_weights=0;
//for($i=0;$i<$num_played;$i++)	$bet_weights+=mysqli_result($bets,$i,'weight');

?>
<script type="text/javascript">
<!--

function comp_total(id){
/*var matches=document.form1.length-2
var weight=new Array(matches)
var match=new Array(matches)
var elm_id=id.substring(6);
//alert(elm_id);

<?php
	$str="";
	$str="";
	for($i=0;$i<$num_first;$i++){
		$match_id=mysqli_result($res,$i,'id');
		if(is_played($match_id)||is_being_played($match_id))	{
			//echo "weight[$match_id]=document.getElementById('weight".$match_id."').innerHTML - 0;\n";
			echo "match[$match_id]=1;\n";
		}	
		else {
			//echo "weight[$match_id]=getCheckedValue(document.form1.weight".$match_id.") - 0;\n";
			//echo "match[$match_id]=getChecked(document.form1.weight".$match_id.") - 0;\n";
		}
		$str=$str.($i?"+":"")."weight[".$match_id."]";
		$str_pick=$str_pick.($i?"+":"")."match[".$match_id."]";
//	if($i==1)	echo "ocument.getElementById('weight".$match_id."').innerHTML);\n";
	}
	//result:total weights
	echo "result=".$str.";\n";
	//picks:total matches
	echo "picks=".$str_pick.";\n";
	//initialize weights already entered
	echo "already=".$bet_weights.";\n";
	//initialize matches already played
	echo "played=".$num_played.";\n";
	//show total points (weights)
	echo "comp_tot(result+already,\"b_text\");\n";
	//show remaining weights
	$rem_weights=$TOT_WEIGHTS-$bet_weights;
//	echo "rem_weights=".$TOT_WEIGHTS."-result;\n";
	echo "comp_tot(".$TOT_WEIGHTS."-result,\"b_textr\");\n";
	//show average per match picked
	echo "avg1='';\n";
	echo "avg2='';\n";
	echo "picks=picks;\n";
	echo "result=result+already;\n";
	echo "if(picks!=0) avg1=result/picks;\n";
	//compute remaining matches
	echo "re_picks =".($fr_m+$sr_m)."-picks;\n";
	echo "if(re_picks!=0) avg2=(".$rem_weights."-result)/re_picks;\n";
	//round the averages
	echo "avg1=parseInt((avg1*100))/100;\n";
	echo "avg2=parseInt((avg2*100))/100;\n";

	echo "if(picks)
		comp_tot(avg1,\"b_textm\");\n";
	//show average per remaining match
	echo "comp_tot(avg2,\"b_textmr\");\n";
	echo "if (((avg2<1)&&avg2)||((avg2='0')&&(rem_weights<0))) warn_player(elm_id);\n";
//	echo "if (((avg2>5)&&avg2)||((avg2='0')&&(rem_weights>0))) notify_player();\n";
//	echo "else clear_warning();\n";
	echo "check_row(elm_id);\n";
//	echo "else clear_warning();\n";	
//	echo "alert('result:'+result+',picks:'+picks+'already:'+already+',played:'+played+',re_picks:'+re_picks);\n";
?>
*/
//-->
	}
</script>

<?php

echo "<div id='foot_main'>";
?>
<!--[if IE]> <p>You are using Internet Explorer: please be careful not to go below the average of 1 point per remaining match, as the page is buggy then. I am working on fixing it. Please use Firefox for more stability.</p> <![endif]--> 
<?php
//echo "<div id='sa_menu_title' style='top:-30px;left:278px;'><img src='img/picks.gif'/></div>\n";
if(still_time(1)) echo "<br><b><i>".remaining_time(0)." day".(remaining_time(0)==1?"":"s")." to go!</i></b><br>";

//see what has been already entered by the user

//take matches that correspond to the first round

$res=mysqli_query($link,"SELECT * FROM matches ORDER BY id");
$num_first=mysqli_num_rows($res);

//check if player has entered any bets
//if he has but hasn't entered them all
//take the top scorer & World Cup Winner
echo "<div id='display_greetings'><a href='javascript:history.back()'> Back</a></div>";
$top=mysqli_query($link,"SELECT winner,top_scorer FROM users WHERE
id='$login_id'") or mysqli_error($link);
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
echo "<form name='form1' method='post' onsubmit=\"javascript:return checkForm(this)\"  action='submit_bets1.php' >";
if(still_time(1)&&!is_played(1)){
	echo "<p class='red'> ".$tournament_name." winner:<b> ";
	drop_down_euro_winner($winner_id);
	echo "</b><span class='standardfont'> If you do not find a certain player, let me know and I'll add his name</span></p>";
	display_drop_down_scorer($top_sc);	
	}
?>
<script type="text/javascript">
<!--
<?php
	if(still_time(1)){
?>
var groups=document.form1.top_sc.options.length
var group=new Array(groups)
	

	for (i=0; i<groups; i++) group[i]=new Array();
	<?php
		$teams=mysqli_query($link,"SELECT team_id FROM teams ORDER BY team_name");
		$num_teams=mysqli_num_rows($teams);
		for($i=0;$i<$num_teams;$i++){
			$tmp_team_id=mysqli_result($teams,$i,'team_id');
			$query="SELECT * from players WHERE players.team_id='".$tmp_team_id."' ORDER BY substring_index(TRIM(name), ' ', -1)";
			$resc=mysqli_query($link,$query);
			if($resc) $num_scorers=mysqli_num_rows($resc);
			else $num_scorers=0;
			for($j=0;$j<$num_scorers;$j++){
				$scorer_name=mysqli_result($resc,$j,'name');
				$scorer_id=mysqli_result($resc,$j,'id');
				if($scorer_id==$top_sc) $defSelected='true';
				else $defSelected='false';
				echo "group[$i][".($j+0)."]=new Option(\"".$scorer_name."\",'$scorer_id');\n";
			}	
		}
	}
?>

//-->
</script>

<?php
function bet_color($pick,$cell){
		if($cell==1) $num=1;
		else $num=2;
		$str='bet_team'.$num.'_display ';
		if($pick==$cell) return($str.'boldf');
		if($pick==2) return($str.'boldf_tie');
		return($str);
}
echo "<div id='bets_table_edit'>\n";
//echo "If you make your pick without assigning points, it is considered as a 1 point pick.";
echo "<table>\n";
for($i=0;$i<$num_first;$i++){

	$match_id=mysqli_result($res,$i,"id");
	$arr=get_match_details($match_id,$login_id);
	echo "<tr id='$match_id' class='bet_match_row'>\n";
	echo "<td class='bet_desc'>".substr($arr["descr"],0,1)."</td>\n";
	echo "<td id='first".$match_id."' class='".bet_color($arr['pick'],1)."'>". $arr["team1"]."</td>\n";
	echo "<td id='pick".$match_id."'  class='bet_score_display'>\n";
		if (!still_time($match_id)||$arr["played"]) echo " ".fscore($arr["goals1"])."&nbsp;-&nbsp;".fscore($arr["goals2"])."\n";
		else display_pick_row($arr["pick"],$arr_pick,$match_id,'all_picks',$arr["no_tie"]);
	echo "\n</td>\n";
	echo "<td id='second".$match_id."' class='".bet_color($arr['pick'],3)."'>\n";
		echo $arr["team2"];
	echo "</td>\n";
	echo "<td class='bet_bet_display'>";
		if(still_time($match_id)&&!$arr["played"]) echo clear_pick_weight($match_id,'pick','clear');
	echo "</td>\n";
	echo "<td class='bet_bet_display'>\n";
		if($arr["played"]) echo f_pick($arr["pick"],$arr["code1"],$arr["code2"]);
		else echo "<div id='full_row".$match_id."'><img src=".($arr['pick']?'checkmark3.gif':'b_drop.png')." alt='empty' height='12px'/></div>";
	echo "</td>\n";
/*	echo "<td id='weight".$match_id."' class='bet_bet_display'>\n";
		if(!still_time($match_id)||$arr["played"]) {
			echo (bet_result($arr["pick"],$arr["goals1"],$arr["goals2"])?"".$arr["weight"]:$arr['weight']);
			}
			else display_weight_row($arr["weight"],$match_id,'all_weights');
	echo "</td>\n";
	echo "<td class='bet_bet_display'>\n";
		if(still_time($match_id)&&!$arr["played"]) echo clear_pick_weight($match_id,'weight','clear pts');
	echo "</td>\n";
		if(still_time($match_id)) echo "<td><input type='hidden' id='name' name='xx".$match_id."' value='$match_id'></td>\n";*/
	echo "</tr>\n";
//	if(($i==15)||($i==30)||($i==45)){
	if(($i==40)){
//		echo "</tr>";
		echo "<tr>";
		//display_weight_info($language);
		echo "</tr>\n";
	}
//show what has been entered so far

$rem=mysqli_query($link,"SELECT id FROM matches WHERE played=0 ORDER BY id") or mysqli_error($link);
$rem_matches=mysqli_num_rows($rem);

}
		echo "<tr>";
		echo "<td  COLSPAN='7'> </td><td>";
		switch($language){
			case 'en':
      		echo "<input id='bet_submit' type='submit' name='Submit' value='Submit'>
		</td><td></td>\n";
			break;
			case 'fr':
      		echo "<input type='submit' name='Submit' value='Valider'>
		</td><td></td>\n";
			break;
			case 'hu';
      		echo "<input type='submit' name='Submit' value='Elküld'>
		</td><td></td>\n";
			break;
		}
		echo "</tr>\n";
?>
</table>
      </div>
</form>
<div id='errors'><div id='error1'></div></div>
