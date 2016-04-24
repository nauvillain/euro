<?php
require 'conf.php';
function make_array($query){
$res=mysql_query($query);
$num_rows=mysql_num_rows($res);
$ydata=array();
// Create the graph. These two calls are always required
$c=rand(0,15)*0.01;
	for($i=0;$i<$num_rows;$i++){
		//get data and add a random component so that lines don't overlap
		$y=mysql_result($res,$i)+$c;
		array_push($ydata,$y);
	}
if(empty($ydata)) $ydata=("0");
return($ydata);
}

function new_line($ydata,$color,$id,$m_type){

	$lineplot=new LinePlot($ydata);
	$lineplot->SetColor($color);
	$lineplot->SetLegend(get_nick($id));
	$a=rand(0,3);
/*	switch($a){
	
		case 0:
			$lineplot->mark->SetType(MARK_FILLEDCIRCLE,'',1);
			break;
		case 1: 
			$lineplot->mark->SetType(MARK_UTRIANGLE,'',1);
			break;
		case 2:
			$lineplot->mark->SetType(MARK_DTRIANGLE,'',1);
			break;
		case 3:
			$lineplot->mark->SetType(MARK_IMG_SBALL,$color,1);
			break;
	}*/
//	$lineplot->mark->SetType(MARK_FILLEDCIRCLE,'',1.0);
	$lineplot->mark->SetType(MARK_IMG_SBALL,$color,1);
	$lineplot->mark->SetColor($color);
	$lineplot->mark->SetFillColor($color);

return($lineplot);
}

function make_array_point_id($id){

	$query="SELECT current_points FROM history WHERE player_id='$id' AND match_id IN (SELECT id FROM matches WHERE played=1) ORDER BY match_id";
	$ydata=make_array($query);

return($ydata);
}

function make_array_matches_graph(){
	
	$query="SELECT t1,t2 FROM matches WHERE played=1";
	$match=mysql_query($query);
	$num=mysql_num_rows($match);
	$array=array();
	for($i=0;$i<$num;$i++){
		$t1=mysql_result($match,$i,'t1');
		$t2=mysql_result($match,$i,'t2');
		$array[$i]=get_team_code($t1)."-".get_team_code($t2);
	}
	return($array);
}

