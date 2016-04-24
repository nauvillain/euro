<?php

require 'php_header.php';
require 'lib/lib_rss.php';
?>
<?php

connect_to_eurodb();
update_last_login($login_id);

//require 'foot_general_info.php';
//gather info about matches played, to display the last results
echo "<div id='foot_main'>\n";
	//show matches played
	echo "<div id='played'>\n";
		require 'foot_matches_played.php';
	echo "</div>";
	//show upcoming matches
	echo "<div id='upcoming'>\n";
		require 'foot_matches_to_come.php';
	echo "</div>";
echo "</div>";
?>
</div>
<div id='connected'>
<?php
display_connected_users($login_id,5);
?>
