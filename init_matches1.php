<?php
require 'php_header.php';
connect_to_eurodb();


	echo "<div id='foot_main'>";
	init_team_data($fr_m);
	reset_matches_played();
	echo "</div>";
?>
	
