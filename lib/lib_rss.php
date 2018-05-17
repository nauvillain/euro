<?php
//require 'config/config_foot.php';
//require 'conf.php';
//require 'lib_foot.php';
//connect_to_eurodb();

function get_result($url){
	$next_match=get_upcoming_match();
//check whether the current time is a good time to check for updates
//test:

	$time_to_update=time_to_update($next_match,1);
	//echo "time to update:".$time_to_update;
	if($time_to_update) {
//	if(1) {
		$match_feed=get_match_feed($url);
		set_latest_query_timestamp();
//test:
//	print_r($match_feed);
//		$match_feed[0]['title']='Greece vs. Poland has ended. Final score: 2 - 0';
//		echo $match_feed['channel']['item'][0]['title'];
		$result=new_result($next_match,$match_feed);
	}
	else $result=0;
	if($result){
		//update matches
			update_scores($next_match,$result['g1'],$result['g2'],1);
			update_all_points();
//		echo 'result!';
	}
}

function get_upcoming_match(){
	global $link;
	$res=mysqli_query($link,"SELECT id FROM matches WHERE played=0 ORDER BY id");
	return(mysqli_result($res,0));
}

function time_to_update($next_match,$scoring){
global $link;	
	$kick_off=starting_time($next_match);
	$match_length=105*60;
	if(tournament_time()>$kick_off+$match_length*$scoring) {
		$res=mysqli_query($link,"SELECT UNIX_TIMESTAMP(timestamp) FROM rss_queries");
		$ts=mysqli_result($res,0);
		$time=time()-$ts;
		//echo "time".$time;
		if($time>60)	return 1;
		else return 0;
	}
	else return 0;
}

function get_match_feed($xmlUrl){
	
//	$xmlUrl = "http://rsslivescores.com/RssTestFeed.aspx"; // XML feed file/URL
	$xmlStr = file_get_contents($xmlUrl);
	$xmlObj = simplexml_load_string($xmlStr);
	return(objectsIntoArray($xmlObj));
	
}	

function set_latest_query_timestamp(){
	mysqli_query("UPDATE rss_queries SET timestamp=FROM_UNIXTIME(".time().")")or die(mysqli_error($link)());
}
function new_result($next_match,$match_feed){
//check if there is a new result in the feed	
//	$size=sizeof($match_feed['channel']['item']);
	$array=array();
	foreach($match_feed['channel'] as $key=>$val){
			if($key=='item'){
				$title=mysql_real_escape_string($val[0]["title"]);
				$pubdate=mysql_real_escape_string($val[0]["pubDate"]);
				$description=mysql_real_escape_string($val[0]["description"]);
				$timestamp=make_timestamp($pubdate);
				//echo $title."---".$pubdate."---".$description."   ".$timestamp."<br/>\n";
				if(new_timestamp($timestamp,$title)) mysqli_query("INSERT INTO rss_history SET title='$title',pubDate='$pubdate',description='$description',timestamp='$timestamp'");
				$array=storedata($val[0]["title"]);	
				$next=get_next_match_info($next_match);
				if($res=compare_data($next,$array)) {
					return($res);
				}
			}
		}
}

function make_timestamp($pubdate){
	
	$dateInfo = date_parse_from_format('D, d M Y H:i:s T',$pubdate);
	$timestamp = mktime(
    	$dateInfo['hour'], $dateInfo['minute'], $dateInfo['second'],
    	$dateInfo['month'], $dateInfo['day'], $dateInfo['year'],
    	$dateInfo['is_dst']);

	return($timestamp);

}
function new_timestamp($timestamp,$title){
//Tue, 12 Oct 2010 22:59:13 GMT


//print_r($dateInfo);
$query=mysqli_query("SELECT id,title FROM rss_history WHERE timestamp='$timestamp' AND title='$title'") or die("error with timestamps");
$num=mysqli_num_rows($query);
if($num>0) return 0; 
else return 1;
}

function objectsIntoArray($arrObjData, $arrSkipIndices = array())
{
    $arrData = array();
    
    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
    
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}



function update_scores($match_id,$g1,$g2,$played){
global $fr_m;
global $last_match;
global $pts_victory,$pts_draw;

		//update matches 		
			$query="UPDATE matches SET played='".$played."',g1='".$g1."',g2='".$g2."' WHERE id='".$match_id."'";
			$q=mysqli_query($query) or die(mysqli_error($link)());
			
			if($match_id==1) init_team_data($fr_m);
		//update team data	
			$phase=get_phase($match_id);
		//update 1st round match
			if(!$phase){	
				$det=get_match_teams($match_id);
				update_team_data($det["team1"],$det["goals1"],$det["goals2"],$pts_victory,$pts_draw);
				update_team_data($det["team2"],$det["goals2"],$det["goals1"],$pts_victory,$pts_draw);
				$letter=get_group($det["team1"]);
				$test=0; //test whether no matches are left in the group
				//rank the teams
				$q=mysqli_query("SELECT team_id,pts,gf,ga,m_played FROM teams WHERE group_name='".$letter."' ORDER by pts DESC,(gf-ga) DESC,gf DESC") or die(mysqli_error($link)());
				$ra=mysqli_num_rows($q);
				for($k=0;$k<$ra;$k++){
					$team_id=mysqli_result($q,$k,'team_id');
					$assign=mysqli_query("UPDATE teams SET current_pos='".($k+1)."' WHERE team_id='$team_id'") or die(mysqli_error($link)());
					$flag=mysqli_result($q,$k,'m_played');
					if($flag!=3) $test++;
				
				}
				//if all matches played, set group over to 1
				if(!$test) {
					mysqli_query("UPDATE groups SET over=1 WHERE letter='".$letter."'") or die(mysqli_error($link)());
					check_group($letter);
				}
				//if groups over, start filling in the next round data
				if (($match_id>($fr_m-6))&&($match_id<$fr_m+1)) {
					$next_phase=$trans_round;
					$trans=mysqli_query("SELECT id FROM matches WHERE round_id='$next_phase'") or die(mysqli_error($link)());
					for($k=0;$k<$next_phase;$k++){
						$m=mysqli_result($trans,$k,'id');
						$teams=submit_winners($m,$next_phase);
						//echo "match $m, t1".$teams['str1'].", t2 ".$teams['str2']."next phase".$next_phase."sr".$sr_l."<br/>";
						update_matches_2ndr($teams['str1'],$teams['str2'],$m);
				
					}
				}
			//update match processed flag
			set_processed($match_id);

			}
		//update 2nd round matches
			if ($match_id>$fr_m) {
				$next_phase=$phase/2;
//				echo "last phase:m:".$val['m_id']."<br/>";
				$trans=mysqli_query("SELECT id FROM matches WHERE round_id='$next_phase'") or die(mysqli_error($link)());
				if($phase!=1){	
					for($k=0;$k<$next_phase;$k++){
						$m=mysqli_result($trans,$k,'id');
//						echo "m:".$m;
						$m=third_place($phase,$m,$next_phase);
						/*if($phase==2)){
						//	$teams=submit_losers($m,$next_phase);
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
					if($match_id==$last_match) set_winner(winner($last_match));
					
				}
			}




}
function check_group($group){
//get group point data
	$query=mysqli_query("SELECT team_id,pts FROM teams WHERE group_name='$group'");
	$num=mysqli_num_rows($query);
//check how many teams have the same amount of points
	for($i=0;$i<$num;$i++){
		$pts[$i]=mysqli_result($query,'pts',$i);
		$arr[$pts[$i]]=0;
		for($j=$i;$j<$num;$i++){
			$pts[$j]=mysqli_result($query,'pts',$j);
			if($pts[$i]==$pts[$j]) {
				$arr[$pts[$i]]+=1;
				$equal[$pts[$i]]=$i;
			}
		}
	}
//parse the results and see whether there are exactly 2 teams with the same amount of points
	foreach($arr as $key=>$val){
		if($val==2){

		//if it is the case, check the history of matches and determine who should be ahead
			$res=mysqli_query("SELECT team_id,current_pos FROM teams WHERE pts='$key'");
			$team1=mysqli_result($res,'team_id',0);
			$team2=mysqli_result($res,'team_id',1);	
			$pos1=mysqli_result($res,'current_pos',1);	
			$pos2=mysqli_result($res,'current_pos',1);	
			$match_query=mysqli_query("SELECT id FROM matches WHERE (t1='$team1' AND team2='$team2') OR (t2='$team1' AND t1='$team2') AND id<'$fr_m'") or die(mysqli_error($link)());
			$arr=get_match_details(mysqli_result($match_query,0));	
		//once the match has been identified, get the goals info; if one team won over the other, and the positions aren't set accordingly, switch them	
			$g1=$arr['goals1'];
			$g2=$arr['goals2'];
			if(($pos1>$pos2&&$g2>$g1)||($pos2>$pos1&&$g1>$g2)) {
				mysqli_query("UDPATE teams SET current_pos='$pos2' WHERE team_id='$team1'");
				mysqli_query("UDPATE teams SET current_pos='$pos1' WHERE team_id='$team2'");
			}
		}
	}
}
function update_all_points(){
global $link;
			$res=mysqli_query($link,"SELECT id,first_name,nickname,city,winner FROM users WHERE player=1");
			$num=mysqli_num_rows($res);

			for($i=0;$i<$num;$i++){

				$p_id=mysqli_result($res,$i,'id');
				//echo "p_id:$p_id<br/>";
				//make sure everyone gets at least a bet of 1 point. 
			//	check_bets($p_id);
				$pts[$p_id]=count_points($p_id);
				$correct[$p_id]=count_correct($p_id);
				//get the winner
				$picked_winner=get_picked_winner($p_id);

			/*	$query="SELECT team_id FROM teams WHERE winner=1 AND team_id='$picked_winner'";
				$sco=mysqli_query($query) or die("Problem with the scorer table");
				$match_winner=mysqli_num_rows($sco);
				
				if($match_winner) $pts[$p_id]+=$bonus_final_winner;*/
				
			}



			arsort($pts);
			//reset($pts);

			//write the result in a table
			foreach($pts as $key=>$val){
				$query="UPDATE users SET current_points=$val WHERE id=$key";
				$res=mysqli_query($link,$query) or die(mysqli_error($link));
				//echo "key:$key, val: $val<br/>";
				if (!$res) echo "issue updating users' points";
			}
			foreach($correct as $key=>$val){
				$query="UPDATE users SET current_correct=$val WHERE id=$key";
				$res=mysqli_query($link,$query) or die(mysqli_error($link));
				//echo "key:$key, val: $val<br/>";
				if (!$res) echo "issue updating users' points";
			}
			$res=mysqli_query($link,"SELECT id,first_name,nickname,city,winner,current_points,current_correct FROM users WHERE player=1 ORDER BY current_points DESC") or die(mysqli_error($link));
			$num=mysqli_num_rows($res);
			$temp=0;
			for ($i=0;$i<$num;$i++){

				$p_id=mysqli_result($res,$i,"id");
				$pts=mysqli_result($res,$i,"current_points");
				$cor=mysqli_result($res,$i,"current_correct");
					
				if($temp!=$pts) $ranking=$i+1;
				$temp=$pts;
				if($i==0) $ranking=1;
				$pl=mysqli_query($link,"UPDATE users SET current_ranking='$ranking' WHERE id='$p_id'") or die(mysqli_error($link));
				}
}
function compare_data($next,$feed){

	$match=0;

	if(($next['t1']==$feed['t1'])&&($next['t2']==$feed['t2'])) {
		$match=1;
		$res['g1']=$feed['g1'];
		$res['g2']=$feed['g2'];
	}
	if(($next['t1']==$feed['t2'])&&($next['t2']==$feed['t1'])) {
		$match=2;
		$res['g1']=$feed['g2'];
		$res['g2']=$feed['g1'];
	}

	if($match) return($res);	
}
function get_next_match_info($next_match){
	$upcoming=mysqli_query("SELECT t1,t2 FROM matches WHERE id='$next_match'") or die(mysqli_error($link)());
	if($upcoming) {
		$a['t1']=get_english_team_name(mysqli_result($upcoming,0,"t1"));
		$a['t2']=get_english_team_name(mysqli_result($upcoming,0,"t2"));
	}
return($a);

}
function get_english_team_name($t){
global $link;
	$res=mysqli_query($link,"SELECT team_name FROM teams WHERE team_id='$t'") or die(mysqli_error($link));
	if(mysqli_num_rows($res)) return mysqli_result($res,0);
}

function storedata($str){

	if(strlen(stristr($str,"Final"))&&strlen(stristr($str,"score"))){
//		echo $str;	
		$res=array();	
// if match ends after penalties, the format becomes: Bayern Munich vs. Chelsea ended after penalties. Final score: 3 - 4

		if(strlen(stristr($str,"penalties"))) $penalties=1;
		else $penalties=0;

		if ($penalties==1) $ended='ended';
		else $ended='has ended';
		
		//get team1
		$res['t1']=trim(substr($str,0,stripos($str,'vs.')));

		//get team2
		$start=stripos($str,'vs.')+3;
		$end=stripos($str,$ended);
		$res['t2']=extract_str($str,$start,$end);

		//get goals team1
		$start=stripos($str,':')+1;
		$end=stripos($str,'-');
		$res['g1']=extract_str($str,$start,$end);
		
		//get goals team2
		$start=stripos($str,'-')+1;
		$end=0;
		$res['g2']=extract_str($str,$start,$end);

	return($res);
	}
}
	

function extract_str($str,$start,$end=0){
	if($end) return(trim(substr($str,$start,$end-$start)));
	else return(trim(substr($str,$start)));
}


?>

