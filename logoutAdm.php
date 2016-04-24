<?php
require 'authAdm.php';
session_destroy();
header("Location:loginAdmin.php");
?>
