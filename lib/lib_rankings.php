
<?php 
function display_ranks($rank,$title,$display,$login_id){
/*$title[0]="Rankings";
$title[1]="Pot Race";
$title[2]="Rankings by correct bets";
$title[3]="Rankings by lost points";
$title[4]="Rankings by points/correct bet";
$title[5]="Rankings by lost points/wrong bet";
*/

	foreach($rank as $v2){
		 $sortpts[]=$v2['pts'];
		 $sortrem[]=$v2['rem'];
		 $sortlost[]=$v2['lost'];
		 $sortname[]=$v2['name'];
		 $sortcurr[]=$v2['curr'];
		 $sortcurrw[]=$v2['curr_w'];
		 $sortppcb[]=$v2['ppcb'];
		 $sortlppwb[]=$v2['lppwb'];
	}
	
	$index=0;
	
	if($display==0) {
		array_multisort($sortpts,SORT_DESC,$sortrem,SORT_DESC,$sortname,SORT_ASC,$rank);
		foreach($rank as $row){
			$ftable[$index]['name']=$row['name'];
			$ftable[$index]['score']=$row['pts'];
			$ftable[$index]['p_id']=$row['p_id'];
			$ftable[$index]['winner']=$row['winner'];
			$index++;
		}
	}
	if($display==1) {
		array_multisort($sortcurr,SORT_DESC,$rank);
		foreach($rank as $row){
			$ftable[$index]['name']=$row['name'];
			$ftable[$index]['score']=$row['curr'];
			$ftable[$index]['p_id']=$row['p_id'];
			$ftable[$index]['winner']=$row['winner'];
			$index++;
		}
	}
	if($display==2) {
		array_multisort($sortlost,SORT_ASC,$rank);
		foreach($rank as $row){
			$ftable[$index]['name']=$row['name'];
			$ftable[$index]['score']=$row['lost'];
			$ftable[$index]['p_id']=$row['p_id'];
			$ftable[$index]['winner']=$row['winner'];
			$index++;
                }
        }
        if($display==3) {
                array_multisort($sortppcb,SORT_DESC,$sortcurr,SORT_DESC,$rank);
                foreach($rank as $row){
                        $ftable[$index]['name']=$row['name'];
                        $ftable[$index]['score']=$row['ppcb'];
                        $ftable[$index]['p_id']=$row['p_id'];
                        $ftable[$index]['winner']=$row['winner'];
                        $index++;
                }
        }
        if($display==4) {
                array_multisort($sortlppwb,SORT_ASC,$sortcurrw,SORT_ASC,$rank);
                foreach($rank as $row){
                        $ftable[$index]['name']=$row['name'];
                        $ftable[$index]['score']=$row['lppwb'];
			//(".$row['curr_w'].")";
                        $ftable[$index]['p_id']=$row['p_id'];
                        $ftable[$index]['winner']=$row['winner'];
                        $index++;
                }
        }
        unset($sortpts) ;
        unset($sortrem) ;
        unset($sortname);
        unset($sortcurr);
        unset($sortppcb);
        unset($sortlppwb);
        unset($sortcurrw);

        display_rank_table($ftable,$login_id);
}

function display_rank_table($ftable,$login_id){
$len=sizeof($ftable);
$j=1;
$group_flag=0;

echo "<br/>&nbsp;<br/>";
echo "<table class='ranking_table' ><tr><td><table>\n";
$temp=-1;
$rank_counter=0;
sqlutf();
for($i=0;$i<$len;$i++){
        $rank_counter+=1;
        $name=$ftable[$i]['name'];
        $score=$ftable[$i]['score'];
        $p_id=$ftable[$i]['p_id'];
        $code=get_country_code($ftable[$i]['winner']);

        $member_query=mysql_query("SELECT id FROM usergroups WHERE user_id='$login_id' AND member='$p_id'");
        if(mysql_num_rows($member_query)) {
                $member=1;
                $group_flag=1;
        }
        else $member=0;
        echo "<tr><td style='width:10px;'>".($score==$temp?"":$j)."</td>\n";
        echo "<td>\n";
                //echo $rank_counter."- </td><td>";
		echo ($code?display_when_live("<img src='img/$code.png' width=15px>"):"")."</td><td>";
		echo "<a href='player_profile.php?id=$p_id' class='display_rank_table'>";
		echo ($p_id==$login_id?"<div class='display_rank_table_me'>":"");
		echo "&nbsp;".substr($name,0,18).($p_id==$login_id?"</div>":"")."</a></td>\n";
        echo "<td>".round($score,2)."</td></tr>\n";
        $j++;
        if($i==floor($len/2)) {
        echo "</table></td><td valign='top'><table class='ranking_table_table'>\n";
        }
        $temp=$score;
}
echo "</table></td></tr></table>\n";
}

function display_pot_numbers(){
global $currency,$money_amount;
		$query=mysql_query("SELECT count(*) FROM users WHERE bet_money=1") or die(mysql_error());
		$total=mysql_result($query,0);
		$total=$total*$money_amount;

		$first=intval($total/100*60);
		$second=intval($total/100*30);
		$third=$total-$first-$second;

		echo "<div class='pot_numbers'>Winner: $first $currency; Runner-up: $second $currency; Third place: $third $currency </div>\n";
}


