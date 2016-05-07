<?php
require 'conf.php';
?>

<div id='title_main' class='boldf'>Rules</div>

<div id='main_rules'>
The rules of this contest are very simple:<br>
- You can make your picks for each match, up until 5 minutes before the match.<br>
<br>
<h4>Points</h4>
<p>
You pick the outcome of each match; you get as many points as the current odds (an assumed initial bet is included as well).
If there are 10 players and 9 bet on outcome A, and 1 bets on outcome B, if A wins, 9 player get 1.1 point (10/9) and if B wins, one player gets 10 points.  
<p>The points are multiplied by a coefficient as follows: 
<table align='center'>
<?php
echo "<tr><td>1st round</td><td>".$coef_round['0']." </td></tr>\n";
echo "<tr><td>Round of 16</td><td>".$coef_round['8']."</td></tr>\n";
echo "<tr><td>Quarter finals</td><td> ".$coef_round['4']."</td></tr>\n";
echo "<tr><td>Semi finals</td><td>".$coef_round['2']."</td></tr>\n";
echo "<tr><td>Finals</td><td> ".$coef_round['1']."</td></tr>\n";
?>
</table>
</p>
</p>
<p>Before the first round starts, you must choose a <b>Tournament Winner</b>. You will get 10 points bonus if your bet is correct. During the second round mddatches, if your winner is still in the competition, you <i>are allowed</i>to bet against your predicted final Winner.</p>
<p>Before the first round starts, you must choose a <b>Tournament Top Scorer</b>. You will get 5 points bonus if your bet is correct.</p>

<h4>Troubleshooting</h4>If you have trouble betting or if you are going to be away from the internet for a while, let me know via
<a href="mailto:vilnico@gmail.com">
email</a>, <u>before the match</u>, to work on a way to place your bets. The simplest way being that you send me the scores of each match via email.</i></p>

</div>
