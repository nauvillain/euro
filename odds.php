<?php
require 'lib.php';

function odds($match_id){
	connect_to_database();

	$query="select * from bets where match_id=$match_id";
	$res=mysql_query($query);
	$num_betters=mysql_num_rows($res);
	$m1=0;
	$m2=0;
	$mD=0;
	for ($i=0;$i<$num_betters;$i++){

		$g1=mysql_result($res,$i,'goals_team1');
		$g2=mysql_result($res,$i,'goals_team2');

		if($g1>$g2) $m1++;
		if($g2>$g1) $m2++;
		if($g2==$g1) $mD++;

	}
if($m1)	$arr[0]=$num_betters/$m1;
else $arr[0]=-1;
if($mD)	$arr[1]=$num_betters/$mD;
else $arr[1]=-1;
if($m2)	$arr[2]=$num_betters/$m2;
else $arr[2]=-1;

	return $arr;

}
$arr=odds(1);
echo "odds for the first match:".(round($arr[0],2))."/".($arr[1])."/".($arr[2]).".";
 
?>
