<?php
require 'auth_foot.php';
require 'config/config_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';
require 'conf.php';

connect_to_eurodb();

function bets_on(){

	$query="SELECT id FROM matches";
	$res=mysql_query($query) or die(mysql_error());
	$num=mysql_num_rows($res);
	$result="";
	$flag="";
	for($i=0;$i<$num;$i++){
		$m_id=mysql_result($res,$i,'id');
		if(still_time($m_id)&&(!is_played($m_id))) $result.=$flag.$m_id;
		$flag=",";
	}
	return($result);
}

//$query="DELETE FROM bets WHERE player_id='$login_id'";
//$sql=mysql_query($query) or die(mysql_error());
/*if (!$sql){
   echo "Sorry! There has been a problem with saving your bets. Please
   go <a href='javascript:history.back()'>back</a> to re-enter them. If the problem persists, please contact
   the administrator.";
   }*/
$count=0;

$sum=0;

//check that weights don't add up to more than the allowed total
$rem_weights=get_remaining_weights($login_id,$TOT_WEIGHTS,0);
//echo "sum:$sum,rem:$rem_weights";
//break;
$rem_matches=mysql_result(mysql_query("SELECT count(*) FROM matches where played=0"),0);
$bets_on=bets_on();
$del=mysql_query("DELETE FROM bets WHERE match_id IN (".$bets_on.") AND player_id='$login_id'");
$match_counter=0;
while(list($key,$val)=each($_POST)){
//	${$key} = $val;
//		echo $key."<br>";
//		echo $val."<br>";
	
	if(($val!="")&&($key!='Submit')&&($key!='stage2')&&($key!='top_sc')&&($key!='winning_team')){
		$count++;
		$cond=substr($key,0,1);
		if($cond=="x"){
			$id=substr($key,2);
			$match[$id]=1;
		}
		if($cond=="p") {
			$col="pick";
			$id=substr($key,4);
			if($val) $pick[$id]=1;
		}
		if($cond=="w"){
		       	$col="weight";
			$id=substr($key,6);
			$sum+=$val;
			if($val) {
				$match_counter++;
				$weight[$id]=1;
			}
			else $weight[$id]=0;
			/*if($sum>=$rem_weights-$rem_matches+$match_counter) {
				header("location:/euro2008/error.php?m_id=1&error=".$sum."-".$rem_weights."-".$rem_matches);
				break;
			}	*/		
		}
//		if(!still_time($id)){
		//	header("location:/euro2008/error.php?m_id=0&error=".htmlspecialchars("Page has expired.id=".$id.". Please click on edit my bets again."));
			
	//	}	
		$s=substr($key,4,1); //takes the character after the 5th one
		//echo $key."<br>";
		$query="SELECT * FROM bets WHERE match_id=$id AND player_id=$login_id";
		//echo $query;
		$sql=mysql_query($query) or die(mysql_error());
		$tot=mysql_num_rows($sql);
		//echo "tot:$tot";
		//if(($sum<=$TOT_WEIGHTS)&&($cond!="x")){
		if(($sum<=$TOT_WEIGHTS)&&($cond!="x")){
			if(!$tot){
				$query="INSERT INTO bets SET $col=$val,match_id=$id,player_id=$login_id";
				//echo $query;
				$sql=mysql_query($query) or die(mysql_error());
			}

			else{
				if(still_time($id)){
					$query="UPDATE bets SET $col=$val WHERE match_id=$id AND player_id=$login_id";
					$sql=mysql_query($query) or die(mysql_error());
				}
			}
		}
		if(!$sql){
			echo 'There has been an error updating the changes. Please contact the webmaster.';
		}
		//update odds
		odds($id);
		//echo $query."<br>\n";
	}
	if($key=='winning_team'){
		$query="UPDATE users SET winner='$val' WHERE
			id='$login_id'";
	
		$player=mysql_query($query) or die(mysql_error()); 
	}
	if($key=='stage2') {
		$query="UPDATE users SET top_scorer='$val' WHERE id='$login_id'";
		mysql_query($query) or die(mysql_error());
	}
	


	unset($sql);
	}
	foreach($match as $key=>$val){
		
//		echo $key."-".$val.":".$weight[$key]."<br/>";
		if($weight[$key]!=1) {
			mysql_query("UPDATE bets SET weight='0' WHERE match_id='$key' and player_id='$login_id'");
		}
		if($pick[$key]!=1) {
			mysql_query("UPDATE bets SET pick='0' WHERE match_id='$key' and player_id='$login_id'");
		}
		
	}
//update odds
check_empty_weights($login_id);
function check_empty_weights($login_id){

	if($login_id){
		$query="SELECT * FROM bets WHERE player_id='$login_id'";
		$res=mysql_query($query) or die(mysql_error());
		$num=mysql_num_rows($res);
		if($num){
			for($i=0;$i<$num;$i++){	
				$pick=mysql_result($res,$i,'pick');
				$weight=mysql_result($res,$i,'weight');
				if($pick&&!$weight) {
					$id=mysql_result($res,$i,'match_id');
					mysql_query("UPDATE bets SET weight=1 WHERE player_id='$login_id' and match_id='$id'") or die(mysql_error());

				}
				if($weight&&!$pick){
					$id=mysql_result($res,$i,'match_id');
					mysql_query("DELETE FROM bets WHERE player_id='$login_id' and match_id='$id'") or die(mysql_error());	
				}
			}
		}
	}
	

}
check_bets($login_id);
header("Location:bets1_saved.php");
?>
