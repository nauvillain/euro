<?php
require 'php_header.php';
connect_to_eurodb();


	echo "<div id='main'>";
	echo "<br/>";
	
					$next_phase=$trans_round;
					$trans=mysql_query("SELECT id FROM matches WHERE round_id='$next_phase'") or die(mysql_error());
					for($k=0;$k<$next_phase;$k++){
						$m=mysql_result($trans,$k,'id');
						$teams=submit_winners($m,$next_phase);
						//echo "match $m, t1".$teams['str1'].", t2 ".$teams['str2']."next phase".$next_phase."sr".$sr_l."<br/>";
						update_matches_2ndr($teams['str1'],$teams['str2'],$m);
}	
	echo "</div>";
?>
	
