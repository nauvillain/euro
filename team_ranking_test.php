<?php
require 'auth.php';
require 'lib.php';
require 'head.php';
require 'header_foot.php';
require 'javascript.php';
require 'hide_script_java.php';

$ROUNDS=5;

connect_to_database();

$arr=create_groups();
$letter=array("A","B","C","D","E","F","G","H");

//show the teams in their different groups
//show the standings per group, sorted
//show the final round chart, with qualified teams
?>
<div id='team_rankings'>
<p>W=Win, D=Draw, L=Loss</p>
<p><a name="first_round"><h2> Team rankings</h2></a></p>
See the<a href='team_ranking.php#final_round'><font color=brown> Final
Round Chart</font></a>
<div id="hideShow">
<table width="98%" cellspacing="10" cellpadding="2" align="center">

<?php
echo "<tr>";
for ($i=0;$i<sizeof($arr);$i++){

if(floor(($i+1)/2)==($i+1)/2) $t=1;
else $t=0;


echo "<td> <b>Group ".$letter[$i]."</b><br><br>\n";
echo "<table width=320 border=1 cellpadding=2>\n
        <tr><td width=110 ><b> Team</b></td>\n
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
	echo "</table></td>";
	if($t==1) echo "</tr><tr>";
}
?>
</tr>
</table>
<br>
</div><a name="final_round"><font colour=brown><h2>Final round!</h2></font></a>
<br>
<a href="team_ranking.php#first_round"> Up </a>
<table width=95% border=0>
<tr><td width=177><img src='2006logo.jpg'>
</td>
<td>
<table width="70%" border=0 cellspacing="1" cellpadding="1" align="center" frame="below">
<?php

echo display_win1(A,0,$ROUNDS,$arr); 		//1
echo display_win2(49,1,$ROUNDS); 		//2
echo display_win1(B,1,$ROUNDS,$arr); 		//3

echo display_win2(57,2,$ROUNDS); 		//4

echo display_win1(C,0,$ROUNDS,$arr);		//5
echo display_win2(50,1,$ROUNDS);		//6
echo display_win1(D,1,$ROUNDS,$arr);		//7

echo display_win2(61,3,$ROUNDS);		//8

echo display_win1(E,0,$ROUNDS,$arr);		//9
echo display_win2(53,1,$ROUNDS);		//10
echo display_win1(F,1,$ROUNDS,$arr);		//11

echo display_win2(58,2,$ROUNDS);		//12

echo display_win1(G,0,$ROUNDS,$arr);		//13
echo display_win2(54,1,$ROUNDS);		//14
echo display_win1(H,1,$ROUNDS,$arr);		//15

echo display_win2(64,4,$ROUNDS);		//16

echo display_win1(B,0,$ROUNDS,$arr);		//17
echo display_win2(51,1,$ROUNDS);		//18
echo display_win1(A,1,$ROUNDS,$arr);		//19

echo display_win2(59,2,$ROUNDS);		//20

echo display_win1(D,0,$ROUNDS,$arr);		//21
echo display_win2(52,1,$ROUNDS);		//22
echo display_win1(C,1,$ROUNDS,$arr);		//23

echo display_win2(62,3,$ROUNDS);		//24

echo display_win1(F,0,$ROUNDS,$arr);		//25
echo display_win2(55,1,$ROUNDS);		//26
echo display_win1(E,1,$ROUNDS,$arr);		//27

echo display_win2(60,2,$ROUNDS);		//28

echo display_win1(H,0,$ROUNDS,$arr);		//29
echo display_win2(56,1,$ROUNDS);		//30
echo display_win1(G,1,$ROUNDS,$arr);		//31
echo display_win2(63,4,$ROUNDS);		//3rd place
?>
</table>
</td></tr></table>
</div>
<?php
require 'footer.php';
?>
