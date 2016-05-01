<?php

function display_winners_top_scorer(){



}

function display_winners_final_winner(){
echo "<div id='end_top_scorers'>";
echo "<div class='title_main_end_tournament'>";
echo "PODIUM <br/>";
echo "</div>\n";
$rest=mysql_query("SELECT * FROM users where current_ranking IN (1,2,3) ORDER BY current_ranking");
$numt=mysql_num_rows($rest);
for ($i=0;$i<$numt;$i++){
	echo "<br/>";
	echo ($i==0?"<div style='font:20px lucida;margin-top:35px;'>WINNER":($i+1))." - ".strtoupper(get_player_name(mysql_result($rest,$i,'id')));
	echo ($i==0?"</div>":"");
}
echo "</div>";


}

function display_championship_winner(){
global $bonus_final_winner;
echo "<div id='end_top_scorers'>";
echo "<div class='title_main_end_tournament'>";
echo "<br/>Final Winner Bonus($bonus_final_winner pts)<br/>";
echo "</div>\n";
$rest=mysql_query("SELECT * FROM teams where winner=1 ");
$numt=mysql_num_rows($rest);
for ($i=0;$i<$numt;$i++){
	$topsc=mysql_result($rest,$i,'team_name');
	echo "<div class='title_main_end_tournament'>";
	echo $topsc."<br/>";
	echo "</div>";
	$top_id=mysql_result($rest,$i,'team_id');
	$resw=mysql_query("SELECT id FROM users WHERE winner='$top_id'") or die(mysql_error());
	$numw=mysql_num_rows($resw);
	for($j=0;$j<$numw;$j++){
		echo get_player_name(mysql_result($resw,$j,'id'));
		echo "<br/>";

	}	
}
echo "</div>";


}

function display_championship_top_scorers(){
global $bonus_scorer;
echo "<div id='end_top_scorers'>";
echo "<div class='title_main_end_tournament'>";
echo "<br/>Top scorers ($bonus_scorer pts)<br/>";
echo "</div>\n";
$rest=mysql_query("SELECT * FROM players where TOP=1 ");
$numt=mysql_num_rows($rest);
for ($i=0;$i<$numt;$i++){
	$topsc=mysql_result($rest,$i,'name');
	echo "<div class='title_main_end_tournament'>";
	echo $topsc."<br/>";
	echo "</div>";
	$top_id=mysql_result($rest,$i,'id');
	$resw=mysql_query("SELECT id FROM users WHERE top_scorer='$top_id'") or die(mysql_error());
	$numw=mysql_num_rows($resw);
	for($j=0;$j<$numw;$j++){
		echo get_player_name(mysql_result($resw,$j,'id'));
		echo "<br/>";

	}	
}
echo "</div>";
}
?>
