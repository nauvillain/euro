<?php 
connect_to_eurodb();

function item($url,$word_id){
echo "<li><a href='$url'>".toUpper(get_word_by_id($word_id))."</a></li>\n";
//echo "<li>&nbsp;</li>\n";
}

?>
<nav>
<div id='menu_wrap'>

<ul id='menu'>
<?php
item('index.php',35);//home
item('rankings.php',34);
/*item('matches.php',33);
item('results.php',36);
item('team_ranking.php',37);
item('stage2.php',40);
item('teams.php',39);*/
item('forum.php?minutes=1440',41);
/*
item('final_winner_top_scorer_list.php',48);
item('display_user_tree.php',79);
item('trends.php',153);*/
?>

<?php
//item('my_bets.php',47);
//item('edit_bets.php',94);
?>
<li><a href="my_bets.php"><?php echo toUpper(get_word_by_id(47));?></a>
<a href="edit_bets.php">(<?php echo toUpper(get_word_by_id(94));?>)</a></li>
<?php
item('player_profile.php?id='.$login_id,45);
//item('set_user_group.php',44);
?>

<?php
//	require 'previous_winners.php';
if(isset($login_id)){	
	admin_links($login_id);
	admin_pot_race_links($login_id);
}
?>
</ul>
</div>
</nav>
<?php
?>

