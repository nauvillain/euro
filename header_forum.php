<ul id='forum_menu'>
<li><a href="index.php">Main page</a></li>
<li><a href="rankings.php">Rankings</a></li>
<li><a href="matches.php">Matches</a></li>
<li><a href='results.php'>Results</a></li>
<li><a href="team_ranking.php">Team Rankings</a></li>
<li><a href="forum.php?method=thread&show=yes">Forum</a></li>
<li><a href="my_bets.php">My bets</a></li>
<li><a href="edit_profile.php">My profile</a></li>
<li><a href="rules.php">Rules</a></li>
<li><a href="logout.php">Log out</a></li>
<?php
	if(is_admin($login_id)) {
		echo "<li><a href='update_matches.php' style='color:black;'>Enter score</a></li>";
		echo "<li><a href='create_user.php' style='color:black;'>Create user</a></li>";
		echo "<li><a href='adlist_users.php' style='color:black;'>List users</a></li>";
		}
?>
</ul>
