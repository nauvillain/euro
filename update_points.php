<?php
require 'php_header.php';
require 'lib/lib_rss.php';
connect_to_eurodb();


	echo "<div id='main'>";
	echo "<br/>";
	
						update_all_points();
	echo "</div>";
?>
	
