<?php

require 'php_header.php';
require 'lib/lib_rss.php';

connect_to_eurodb();
update_last_login($login_id);
//$url='http://www.rsslivescores.com/RssService.aspx?sid=32&id=202E56A5-BD3A-4FF3-B942-234391AE27C8';
//get_result($url);
//gather info about matches played, to display the last results
echo "<div id='foot_main'>\n";
	//show matches played
	require 'rss_live_feed_display.php';
	echo "<div id='played'>\n";
		require 'foot_matches_played.php';
	echo "</div>";
	//show upcoming matches
	echo "<div id='upcoming'>\n";
		require 'foot_matches_to_come.php';
	echo "</div>";
echo "</div>";
?>
