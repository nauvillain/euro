<?php

require 'php_header.php';
require 'javascript.php';
require 'js/all_checkboxes.js';

connect_to_eurodb();
echo "<div id='foot_main'>";
if(!is_admin($login_id)){
	echo "Sorry, for admin purposes only!";	
	break;
	}



/*Show the matches that have been played already
and the rest of them; show the radio buttons confirming they were
played*/


$res=mysql_query("SELECT round_id FROM
matches WHERE played=0 ORDER BY id") or die(mysql_error());
$num=mysql_num_rows($res);

/*See how many matches have been played
and show the matches up to the end of the corresponding round*/

$phase=mysql_result($res,0,'round_id');

$res=mysql_query("SELECT * from matches WHERE round_id='$phase' ORDER by id") or die(mysql_error());
$num=mysql_num_rows($res);
echo " <form name='update_matches' method='post' action='submit_matches.php'>";
echo "<input type='submit' name='Submit' value='Submit' style='float:right;'>";
?>
<input type="button" onclick="SetAllCheckBoxes(true);" value="Check all">
&nbsp;&nbsp;
<input type="button" onclick="SetAllCheckBoxes(false);" value="Uncheck all">

<?php
echo "<div id='bets_table'>\n";
echo "<table>\n";


for ($i=0;$i<$num;$i++) {


$match_id=mysql_result($res,$i,'id');
$arr=get_match_details($match_id,$login_id);
	echo "<tr class='bet_match_row'>\n";
	echo "<td class='bet_desc'>".$arr["descr"]."</td>";
	echo "<td class='bet_team1_display'>". $arr["team1"]."</td>\n";
	echo "<td class='bet_score_display_edit'>\n";
		//if (!still_time($match_id)||$arr["played"]) echo " ".fscore($arr["goals1"])."&nbsp;-&nbsp;".fscore($arr["goals2"])."\n";
			display_score_row($match_id,'all_picks',$arr["goals1"],$arr["goals2"]);
	echo "\n</td>\n";
	echo "<td class='bet_team2_display'>";
		echo $arr["team2"];
	echo "</td>";
	echo "<td class='bet_team2_display'>";
		echo display_checkbox($match_id,$arr["played"]);
	echo "</td>";
}
?>
</table>
<input type="button" onclick="SetAllCheckBoxes(true);" value="Check all">
&nbsp;&nbsp;
<input type="button" onclick="SetAllCheckBoxes(false);" value="Uncheck all">
</form>

      <input type="hidden" name="phase" value="<?php echo $phase;?>" style='float:right;'>
      <input type="submit" name="Submit" value="Submit" style='float:right;'>
</form>

