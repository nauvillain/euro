<?php
require 'authAdm.php';
require 'head.php';
require 'headerAdm.php';
require 'lib.php';
require 'javascript.php';
?>
<TITLE>Admin Main Page- Euro 2004</TITLE>
<p><h4> Manage the database</h4></p>
<p><a href="adlist_users.php">Show all users</a></p>
<?php

connect_to_database();
$result=mysql_query("SELECT id,player FROM users");
$num=mysql_num_rows($result);
mysql_free_result($result);
$result=mysql_query("SELECT id FROM matches WHERE played=1");
$num2=mysql_num_rows($result);

$sco=mysql_query("SELECT id,top_scorer FROM scorer");
$num3=mysql_num_rows($sco);

$pla=mysql_query("SELECT id FROM users WHERE player=1");
$num4=mysql_num_rows($pla);

?>
<p><i> To this day, <?php echo $num; ?> users registered (<?php echo $num4?> of them players). 
<?php
?>
<p><a href='fr_sr.php'>test second round</a></p>
<p><a href='sr_fr.php'>test first round</a></p>
<p><a href='enter_scorer_adm.php'>enter scorer</a></p>
<p><a href='enter_winner_adm.php'>enter winner</a></p>
<p><a href='init_matches.php'>Re-initialize second round matches</a></p>
<p><a href='bets_per_player.php'>See who hasn't completed their first round matches</a></p>
<p><a href='compute_odds.php'>Update odds db</a></p>
<p><a href='list_id.php'>List of IDs</a></p>
<p><a href='list_email.php'>List of emails</a></p>
<p><a href='last_activity.php'>Last activity</a></p>
<p><a href='mark_top_scorer_adm.php'>Add current top scorer</a></p>
<p><a href='remove_current_top_scorer_adm.php'>Remove current top scorer</a></p>

<p><a href="javascript:openwin('change_passwordAdm.php',350,210)"><font color=gray>Change password</font></a></p><br>
<?php
require 'footer.php';
?>

