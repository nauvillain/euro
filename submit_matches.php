<?php
require 'auth_foot.php';
require 'conf.php';
require 'config/config_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';
require 'class/autoload.php';
$DB = DB::Open();
global $fr_m,$sr_l,$third_place_match,$last_match;

connect_to_eurodb();
//since empty checkboxes do not appear, we have to reset 'played' to 0 and change it to 1 when the checkbox is checked.

$k=0; //initializing the array index

while(list($key,$val)=each($_POST)){


	$$key = $val;

//echo $key." ".$val."<br/>\n";
	if(!empty($key)){

		//extract the match number and the team ID (1 or 2)
		//check whether the match has been played
		$s=substr($key,0,1);
		if($s=='s'){
			$f=substr($key,5,1)+1;
			$match_id=substr($key,6);
//			echo "m:$match_id f:$f ;val:$val<br/>";
			if($val=='on')	{
				$re[$k]["played"]=1;
				$re[$k]["m_id"]=$match_id;
				$k++;
			}
			else {
				$re[$k]["g".$f]=$val;
			}
			
		}
	}

}
//$sort_m[]=$re['m_id'];
//print(sizeof($re)."and".sizeof($sort_m));
//array_multisort($sort_m,SORT_ASC);
//array_multisort($sort_m,SORT_ASC,$re);
/*echo 'test.';
print_r(array_values($re));
foreach($re as $val){
			echo "m_id:".$val['m_id']."-phase:";
			$phase=get_phase($val['m_id']);
			echo $phase."<br/>";
			}
break;*/



foreach($re as $val){
	if($val['played']==1){
		if($val['m_id']){
			$latest_m_id=$val['m_id'];
			$query="UPDATE matches SET played='".$val['played']."',g1='".$val['g1']."',g2='".$val['g2']."' WHERE id='".$val['m_id']."'";
			$q=mysql_query($query) or die(mysql_error());
			if($val['m_id']==1) init_team_data($fr_m);
			//get phase!
			$phase=get_phase($val['m_id']);
			if(!$phase){	
				$det=get_match_teams($val['m_id']);
				update_team_data($det["team1"],$det["goals1"],$det["goals2"],$pts_victory,$pts_draw);
				update_team_data($det["team2"],$det["goals2"],$det["goals1"],$pts_victory,$pts_draw);
				$letter=get_group($det["team1"]);
				$test=0; //test whether no matches are left in the group
				//rank the teams
				$q=mysql_query("SELECT team_id,pts,gf,ga,m_played FROM teams WHERE group_name='".$letter."' ORDER by pts DESC,(gf-ga) DESC,gf DESC") or die(mysql_error());
				$ra=mysql_num_rows($q);
				for($k=0;$k<$ra;$k++){
					$team_id=mysql_result($q,$k,'team_id');
					$assign=mysql_query("UPDATE teams SET current_pos='".($k+1)."' WHERE team_id='$team_id'") or die(mysql_error());
					$flag=mysql_result($q,$k,'m_played');
					if($flag!=3) $test++;
				
				}
				//if all matches played, set group over to 1
				if(!$test) mysql_query("UPDATE groups SET over=1 WHERE letter='".$letter."'") or die(mysql_error());
				//if groups over, start filling in the next round data
				if (($val['m_id']>($fr_m-6))&&($val['m_id']<$fr_m+1)) {
					$next_phase=$trans_round;
					$trans=mysql_query("SELECT id FROM matches WHERE round_id='$next_phase'") or die(mysql_error());
					for($k=0;$k<$next_phase;$k++){
						$m=mysql_result($trans,$k,'id');
						$teams=submit_winners($m,$next_phase);
						//echo "match $m, t1".$teams['str1'].", t2 ".$teams['str2']."next phase".$next_phase."sr".$sr_l."<br/>";
						update_matches_2ndr($teams['str1'],$teams['str2'],$m);
				
					}
				}
			}

			if ($val['m_id']>$fr_m) {
				$next_phase=$phase/2;
//				echo "last phase:m:".$val['m_id']."<br/>";
				$trans=mysql_query("SELECT id FROM matches WHERE round_id='$next_phase'") or die(mysql_error());
				if($phase!=1){	
					for($k=0;$k<$next_phase;$k++){
						$m=mysql_result($trans,$k,'id');
//						echo "m:".$m;
						$m=third_place($phase,$m,$next_phase);
						/*if($phase==2)){
							$teams=submit_losers($m,$next_phase);
							update_matches_2ndr($teams['str1'],$teams['str2'],$m);
							$m+=1;
						}*/
						$teams=submit_winners($m,$next_phase);
						//echo "match $m, t1".$teams['str1'].", t2 ".$teams['str2']."<br/>";
						update_matches_2ndr($teams['str1'],$teams['str2'],$m);
					}
				}
				
				else {
					//if third place match
					if($val['m_id']==$last_match) set_winner(winner($last_match));
					
				}
			}


		}
	}
}
//echo $query."<br/>\n";
///RANK TEAMS 
//if end of first round, insert teams in the list of matches
//echo $num_matches.":".$fr_m;
$res=mysql_query("SELECT id FROM matches WHERE played=1");
$num_played=mysql_num_rows($res);



//break;

//update players' points


//select players
   
$res=mysql_query("SELECT id,first_name,nickname,city,winner FROM users WHERE player=1");
$num=mysql_num_rows($res);

for($i=0;$i<$num;$i++){

	$p_id=mysql_result($res,$i,'id');
	//echo "p_id:$p_id<br/>";
	//make sure everyone gets at least a bet of 1 point. 
//	check_bets($p_id);
	$pts[$p_id]=count_points($p_id);
	$correct[$p_id]=count_correct($p_id);
	//get the winner
	$picked_winner=get_picked_winner($p_id);

/*	$query="SELECT team_id FROM teams WHERE winner=1 AND team_id='$picked_winner'";
	$sco=mysql_query($query) or die("Problem with the scorer table");
	$match_winner=mysql_num_rows($sco);
	
	if($match_winner) $pts[$p_id]+=$bonus_final_winner;*/
  	
}



arsort($pts);
//reset($pts);

//write the result in a table
foreach($pts as $key=>$val){
	$query="UPDATE users SET current_points=$val WHERE id=$key";
	$res=mysql_query($query) or die(mysql_error());
	//echo "key:$key, val: $val<br/>";
	if (!$res) echo "issue updating users' points";
}
foreach($correct as $key=>$val){
	$query="UPDATE users SET current_correct=$val WHERE id=$key";
	$res=mysql_query($query) or die(mysql_error());
	//echo "key:$key, val: $val<br/>";
	if (!$res) echo "issue updating users' points";
}
$res=mysql_query("SELECT id,first_name,nickname,city,winner,current_points,current_correct FROM users WHERE player=1 ORDER BY current_points DESC") or die(mysql_error());
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++){

	$p_id=mysql_result($res,$i,"id");
	$pts=mysql_result($res,$i,"current_points");
	$cor=mysql_result($res,$i,"current_correct");
  		
	if($temp!=$pts) $ranking=$i+1;
	if($i==0) $ranking=1;
	$pl=mysql_query("UPDATE users SET current_ranking='$ranking' WHERE id='$p_id'") or die(mysql_error());
	$temp=$pts;
}

if($pl) header("Location:index.php");
else  echo "Error updating matches. Please contact the administrator.";
?>
