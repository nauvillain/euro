<?php
require 'php_header.php';
require 'javascript.php';
require 'hide_script_java.php';

$ROUNDS=3;

connect_to_eurodb();

$arr=create_groups();
$letter=array("A","B","C","D");

//show the teams in their different groups
//show the standings per group, sorted
//show the final round chart, with qualified teams
?>
<div id='main'>
<div id='temp_items'>W=Win, D=Draw, L=Loss</div>
<a name="first_round"><div id='title_main'> Team rankings</div></a>
<div id='display_greetings'><a href='matches.php'>Matches</a></div>
<div id="hideShow">
<table width="98%" cellspacing="10" cellpadding="" align="center">

<?php
echo "<tr>";
for ($i=0;$i<sizeof($arr);$i++){

if(floor(($i+1)/2)==($i+1)/2) $t=1;
else $t=0;


echo "<td> <b>Group ".$letter[$i]."</b><br><br>\n";
echo "<div id='team_ranking' class='standardfont'>";
echo "<table cellspacing=0px>\n

        <tr><td width=85 ><b> Team</b></td>\n
        <td width=10><b>Pld</b></td>\n
        <td width=10><b>W&nbsp;</b></td>\n
        <td width=10><b>D&nbsp;</b></td>\n
        <td width=10><b>L&nbsp;</b></td>\n
        <td width=10><b>GF</b></td>\n
        <td width=10><b>GA</b></td>\n
        <td width=10><b>GD</b></td>\n
        <td width=10><b>Pts</b></td>\n
        </tr>\n";
        $grpa=g_sort($arr[$letter[$i]]);
        show_standings($grpa);
	echo "</table></div></td>";
	if($t==1) echo "</tr><tr>";
}
?>
</tr>
</table>
<br>
</div>
<div id='menu_center'><a name="final_round" class='boldf'> Final round</a></div>
<br>
<div id='display_final_round'>
<table width="100%" border=0 cellspacing="1" cellpadding="1" align="center" frame="below">
<?php
make_final_round_chart_euro($ROUNDS,$arr);
?>
</table>
</div>
</div>
<?php
require 'foot_foot.php';
?>
