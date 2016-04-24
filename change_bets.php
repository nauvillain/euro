<?php
require 'php_header.php';
echo "<script type='text/javascript' src='js/javascript_bets.js'>\n";
echo "</script>\n";
?>
<script type="text/javascript">
<!--
function comp_bet(rem_pts,cur_pts,unbet,newb,tot_matches){
	
	rem_pts=rem_pts-0;
	unbet=unbet-0;
	newb=newb-0;
	cur_pts=cur_pts-0;
	tot_matches=tot_matches-0;
	rem_pts=rem_pts+cur_pts;
		
	var weights=document.form1.weight;

	var new_weight=getCheckedValue(weights)-0;
	if(!unbet) {
		avg='';
//		alert('nounb'+'r'+rem_pts+'c'+cur_weight+'n'+new_weight);
		comp_tot(rem_pts+newb-new_weight,'rem_pts');
	}
	else {
		if((unbet==1&&newb)||!unbet) avg='';
		else avg=(rem_pts-new_weight+unbet)/(unbet-newb);
//		alert('unb'+unbet+'r'+rem_pts+'c'+cur_pts+'n'+new_weight+'last'+newb);
		comp_tot(rem_pts+unbet-new_weight,'rem_pts');
	}
	avg=parseInt((avg*100))/100;
	cond=0;
	if((avg<1)&&(unbet>'1')) cond=1;
	if((unbet=='1')&&(new_weight>rem_pts+newb)) cond=1;
	if(!unbet&&(new_weight>rem_pts+newb)) cond=1;;
	if(newb&&(rem_pts+newb-new_weight=='0')) comp_tot('All points used !','last');
	else comp_tot('','last');	
	if(cond) {
		if(!newb) alert('Not enough points left!\nPlease make sure you do not have less than 1pt/remaining match on average');
		else alert('Total point limit exceeded!');
		clearWeights();
		comp_bet(rem_pts,0,unbet,newb,tot_matches);
	};

	comp_tot(avg,'avg_pts');
}
//-->
</script>
<?php
$match_id=$_REQUEST['id'];
$played=matches_played();
$rem_played=$fr_m+$sr_m-$played;
$rem_pts=get_remaining_weights($login_id,$TOT_WEIGHTS,$match_id);
$res=still_time($match_id);
$unbet=num_unbet_matches($login_id,$fr_m+$sr_m);
$newb=is_new($login_id,$match_id);
if ($res!=0&&!is_played($match_id)){
	$arr=get_match_details($match_id,$login_id);

	echo "<div id='main'>";
	echo "<div id='temp_items'>".utf8_encode($arr["place"])."</div><div id='display_greetings'> ".substr($arr["time"],0,5)."   ".date("l F dS",strtotime($arr["date"]))."</div>\n";



	$diff=$res-time();
	$days=floor($diff/86400);
	$hours=floor(($diff-86400*$days)/3600);
	$min=floor(($diff-3600*$hours-86400*$days)/60);

	echo "<div class='middle'>You still have ".($days>0?$days.' days, ':'')."$hours".($hours>0?'hours, and ':'')."$min min to place your bet.</div>";

	echo "<form name='form1' method='post' action='bet2_submit.php' class='middle'>";

	echo "<div class='cb_match_board'>\n";
	
	echo "<div class='cb_mb_teams_display'><img src='img/".$arr["code1"].".gif'>&nbsp;".$arr["team1"];
	display_pick($arr["pick"],$arr_pick,$arr['no_tie']);
//	echo "	&nbsp; - &nbsp;";
	echo $arr["team2"]."&nbsp;
	<img src='img/".$arr["code2"].".gif'>\n</div>";
	$tot_matches=$fr_m+$sr_m;
	display_weight($arr["weight"],$rem_pts,$unbet,$newb,$tot_matches);

	

	echo "</div>";
	echo "<input type=hidden name='match_id' id='match_id' value='$match_id'><br/>";
	echo "<div style='margin:0 auto;width:80px;'><input type=submit name='Submit' value='Submit'>";
	echo "</div>";
	echo "</form>";
	echo "<br/><div id='total_points' class='middle'>Point unallocated: <div id='rem_pts'></div><div>     </div>Average pts per remaining match: <div id='avg_pts'></div><br/>     <div id='last'></div></div>\n";
?>
<script type="text/javascript">
<!--
<?php
	echo "comp_bet('".$rem_pts."','".$arr['weight']."','".$unbet."','".$newb."','".$tot_matches."');\n";
?>
//-->
</script>
<?php
//	echo "played:$played,rem_played=$rem_played,rem_pts=$rem_pts,unbet:".$unbet;
	}
else{
	echo "<br/><br/><div class='title_main'>it's too late to bet!</div>";
}
echo "</div>";
require 'foot_foot.php';
?>
