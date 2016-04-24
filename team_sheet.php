<?php

require 'php_header.php';
css("team_sheetcss.css");

function display_history($team_id){
global $login_id;
	$query="SELECT * FROM matches WHERE (t1='$team_id' or t2='$team_id') and played=1 ORDER by id";
	$res=mysql_query($query) or die(mysql_error());
	$num=mysql_num_rows($res);
	for($i=0;$i<$num;$i++){
		$match_id=mysql_result($res,$i,'id');
		$ma=get_match_details($match_id,$login_id);
		display_match_item($ma);
}
}
function display_match_item($ma){

	
	$class=get_class1($ma);
	display($ma['team1'],$class['t1'],$ma['t_id1'],1);
	display($ma['goals1'],'hist_g1',0,1);
	display_dash();
	display($ma['goals2'],'hist_g2',0,2);
	display($ma['team2'],$class['t2'],$ma['t_id2'],2);
	

}
function display_dash(){
	echo "<div class='hist_dash'>-</div>\n";
}
function team_link($id){
	echo "<a href='teams.php?id=".$id."'>&nbsp;".get_team_name($id)."</a>\n";
}
function get_class1($ma){
	$winner=winner($ma['m_id']);
	$class['t1']='hist_t1';
	$class['t2']='hist_t2';
	if($ma['t_id1']==$winner) {
		$class['t1']='hist_t1_bold';
		}
	if($ma['t_id2']==$winner){
		$class['t2']='hist_t2_bold';
	}
return $class;
}

function display($text,$class,$team_id,$side){
	echo "<div class='$class'>\n";
	if($side==1) $style='right';
	if($side==2) $style='left';
	if($team_id) echo "<span style='float:$style'>".get_team_name_link($team_id,2)."</span>";
	else echo ($side==1?"&nbsp;&nbsp;":"").$text;
	echo "</div>\n";
}

function show_flag($code){
	echo "<img src='img/".$code.".png' height='25px' />\n";
}
?>
<div id='foot_main'>
<?php
$team_id=$_REQUEST['id'];
//display_groups_links();
?>
<div id='main_hist'>
<div id='title_main_ts'>
<?php
mysql_set_charset(utf8);
show_flag(get_country_code($team_id));
echo team_link($team_id);
?>
</div>
<h4 class='middle'>
<?php 
echo get_word_by_id(36);?>
</h4>
<?php
display_history($team_id);
display_all_groups(get_group($team_id));
echo "<div id='team_ranking_all'>";
$gp=array(get_group($team_id));
$gr=array_diff($groups,$gp);
$gr=array_values($gr);
display_all_groups($gr);
echo "</div>\n";
?>
&nbsp;
</div>
</div>
