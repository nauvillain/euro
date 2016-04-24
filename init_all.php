<?php
require 'php_header.php';
if(!is_admin($login_id)){
	echo "Sorry, for admin purposes only!";	
	break;
	}

echo "<div id='foot_main'>\n";

	echo "BE CAREFUL WITH THIS :).<br/>";

		echo "<a href='init_matches1.php' style='color:gray;'>reset matches</a><br/>";
		echo "<a href='init_bets1.php' style='color:gray;'>reset bets</a><br/>";


?>
