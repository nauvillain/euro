<?php
require 'php_header.php';
require 'rss1.php';
echo "<div id='foot_main'>";
$url='http://www.rsslivescores.com/RssService.aspx?sid=32&id=202E56A5-BD3A-4FF3-B942-234391AE27C8';
get_result($url);
function extractrsstitle($str){

//		echo $str;	
		$res=array();	
// if match ends after penalties, the format becomes: Bayern Munich vs. Chelsea ended after penalties. Final score: 3 - 4

		
		//get team1
		$res['t1']=trim(substr($str,0,stripos($str,'vs.')));

		//get team2
		$start=stripos($str,'vs.')+3;
		$end=stripos($str,"Live");
		$res['t2']=extract_str($str,$start,$end);

		//get goals team1
		$start=stripos($str,'Live score')+10;
		$end=stripos($str,'-');
		$res['g1']=extract_str($str,$start,$end);
		
		//get goals team2
		$start=stripos($str,'-')+1;
		$end=stripos($str,'Goal');
		$res['g2']=extract_str($str,$start,$end);
if(stripos($str,"Live score")) $res['score']=1;
else $res['score']=0;
	return($res);
}

$next_match=get_upcoming_match();
//if(is_being_played($next_match)) {
if (1) {//$match_feed=get_match_feed($url);
//new_result($next_match,$match_feed);
//	$kick_off=starting_time($next_match);
	//echo "time to update:".$time_to_update;
	if(1) {
//	if(time_to_update($next_match,0)) {
		$match_feed=get_match_feed($url);
		set_latest_query_timestamp();
//test:
//	print_r($match_feed);
//		$match_feed[0]['title']='Greece vs. Poland has ended. Final score: 2 - 0';
//		echo $match_feed['channel']['item'][0]['title'];
		if(is_being_played($next_match))   new_result($next_match,$match_feed);
//		if(is_being_played($next_match+1))   new_result($next_match+1,$match_feed);
}
function match_news_update($next_match){
	$t1=mysql_result(mysql_query("SELECT t2 FROM matches where id='$next_match'"),0);
	$team1=mysql_result(mysql_query("SELECT team_name FROM teams WHERE team_id='$t1'"),0);

	$good_timestamp=time()-3*3600;
	echo "<div class='rss_live_feed_display'>\n";
	$timest=" AND timestamp > '$good_timestamp' ";
		$qq=mysql_query("SELECT title,description FROM rss_history WHERE title LIKE \"%$team1%\" ".$timest." ORDER BY timestamp DESC LIMIT 1") or die(mysql_error());
		if(mysql_num_rows($qq)) {
		$title=mysql_result($qq,0,'title');
		$desc=mysql_result($qq,0,'description');
	}
	echo $title."    ".$desc."<br/>";
	//echo "(test)England vs. Montenegro has ended. Final score: 1 - 0";
	echo "</div>\n";
	return($title);
}
	if(is_being_played($next_match)) $title[$next_match]=match_news_update($next_match);

}
?>
