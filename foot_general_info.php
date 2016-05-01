<?php
//part of foot.php

if(isset($login_id)){
	timestamp_access($login_id);
	display_greetings($login_id);
}
?>
