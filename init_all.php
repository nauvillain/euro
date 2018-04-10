<?php
require 'php_header.php';

$flag=1;
while ($flag){
 	if (is_admin($login_id)) {
		
		echo "<div id='foot_main'>\n";
		echo "BE CAREFUL WITH THIS :).<br/>";
		echo "<br/><br/><a href='init_matches1.php' style='color:gray;'>reset matches</a><br/>";
		echo "<br/><br/><br/><br/><a href='init_bets1.php' style='color:gray;'>reset bets</a><br/>";
		break;
	}
	else {
		echo "admin only, sorry!";
		break;
	}
}



?>
