<?php
require 'php_header.php';
require 'javascript.php';
require 'javascript_form.php';

echo "<div id='main'>";
echo "<div id='sa_menu_title' style='top:-30px;left:230px;'><img src='img/winners_scorers.gif'/></div>\n";
connect_to_eurodb();
$res=mysql_query("SELECT first_name,nickname,winner,top_scorer,id FROM users  WHERE player=1") or die(mysql_error());

$type=$_GET['type'];
if(!$type) $type=1;
$title[1]="name";
$title[2]="winner";
$title[3]="top scorer";


function display_wts_table($ftable,$title){

$len=sizeof($ftable);

	echo "<table width='90%' align='center'>\n";

	echo "<tr>\n";
	for($i=1;$i<4;$i++) {
		echo "<td><a href='final_winner_top_scorer_list.php?type=$i'>".$title[$i]."</a></td>\n";
	}
	echo "</tr>";
	for($i=0;$i<$len;$i++){
		
		$name=$ftable[$i]['name'];
		$winner=$ftable[$i]['winner'];
		$scorer=$ftable[$i]['top_scorer'];
		$id=$ftable[$i]['id'];
		
		echo "<tr><td><a href='player_profile?id=$id'>".$name."</td>\n";
		echo "<td>".$winner."</a></td>\n";
		echo "<td>".$scorer."</td></tr>\n";
	}
	echo "</table>\n";

	}
	?>
	<div style='margin:25px';>
	<?php

//	echo "<h2 class='middle'> Final Winners / Top Scorers</h2>";
	$i=0;	
		while($row=mysql_fetch_array($res)){
			if($row['nickname']) $temp['name']=$row['nickname'];
			else $temp['name']=$row['first_name'];
			$temp['winner']=get_team_name($row['winner']);
			$temp['top_scorer']=find_scorer_name($row['top_scorer']);
			$temp['id']=$row['id'];
			$arr[$i]=$temp;
			unset($temp);
			$i++;
		}
		foreach($arr as $v){
			$first[]=$v['name'];
			$win[]=$v['winner'];
			$top[]=$v['top_scorer'];	
		}
		if($type==1) array_multisort($first,SORT_ASC,$arr);
		if($type==2) array_multisort($win,SORT_ASC,$arr);
		if($type==3) array_multisort($top,SORT_ASC,$arr);

		if(!still_time(1)) display_wts_table($arr,$title);
		else {
			echo "<div class='middle'>\n";
			switch($language){
				case 'en': echo "The list of top scorers & final winner bets by each player will be displayed after kick-off.</div>";			break;
				case 'fr': echo "La liste des paris sur le vainqueur final et le meilleur buteur sera affichée une fois la compétition commencée.";
				break;
				case 'hu': echo "A leadott tippek a győztesekre és az aranylábúakra a bajnokság kezdete után lesznek láthatóak.";
				break;
			}
			echo "</div>\n";
		}
		
?>
</div>

<?php


?>








