<?php
require 'php_header.php';
echo "<script type='text/javascript' src='js/javascript_bets.js'>\n";
echo "</script>\n";
$match_id=$_REQUEST['id'];
$played=matches_played();
$rem_played=$fr_m+$sr_m-$played;
//$rem_pts=get_remaining_weights($login_id,$TOT_WEIGHTS,$match_id);
$res=still_time($match_id);
//$unbet=num_unbet_matches($login_id,$fr_m+$sr_m);
$newb=is_new($login_id,$match_id);
if ($res!=0&&!is_played($match_id)){
	$arr=get_match_details($match_id,$login_id);

	echo "<div id='foot_main'>";
	echo "<div id='temp_items'>".$arr["place"]."</div><div class='display_greetings_cb'> ".substr($arr["time"],0,5)."   ".date("l F dS",strtotime($arr["date"]))."</div>\n";



	$diff=$res-tournament_time();
	$days=floor($diff/86400);
	$hours=floor(($diff-86400*$days)/3600);
	$min=floor(($diff-3600*$hours-86400*$days)/60);

	echo "<div class='middle'>You still have ".($days>0?$days.' days, ':'').$hours.($hours>0?'hours, and ':'').$min." min to place your bet.</div>";

	echo "<form name='form1' method='post' action='bet2_submit.php' class='middle'>";

	echo "<div class='cb_match_board'>\n";
	
	echo "<div class='cb_mb_teams_display'><img src='img/".$arr["code1"].".gif'>&nbsp;".get_team_name_link($arr["t_id1"],1);
	display_pick($arr["pick"],$arr_pick,$arr['no_tie']);
//	echo "	&nbsp; - &nbsp;";
	echo get_team_name_link($arr["t_id2"],1)."&nbsp;
	<img src='img/".$arr["code2"].".gif'>\n</div>";
	$tot_matches=$fr_m+$sr_m;
//	display_weight($arr["weight"],$rem_pts,$unbet,$newb,$tot_matches);

	

	echo "</div>";
echo "<div class='change_bet_bottom'><br/>1=".get_team_name($arr['t_id1']).", X=".get_word_by_id(103).", 2=".get_team_name($arr['t_id2'])."</div>\n";
	echo "<input type=hidden name='match_id' id='match_id' value='$match_id'><br/>";
	echo "<div id='bet_submit' style='margin:0 auto;'><input type=submit name='Submit' value='Submit' >";
	echo "</div>";
	echo "</form>";
	echo "<br/>";
//	echo "<br/><div id='total_points' class='middle'>Point unallocated: <div id='rem_pts'></div><div>     </div>Average pts per remaining match: <div id='avg_pts'></div><br/>     <div id='last'></div></div>\n";
/*?>
<script type="text/javascript">
<!--
<?php
//	echo "comp_bet('".$rem_pts."','".$arr['weight']."','".$unbet."','".$newb."','".$tot_matches."');\n";
?>
//-->
</script>
<?php
//	echo "played:$played,rem_played=$rem_played,rem_pts=$rem_pts,unbet:".$unbet;
*/
	}
else{
	echo "<div class='change_bet_bottom'><br/>it's too late to bet!</div>";
}
echo "</div>";
?>
