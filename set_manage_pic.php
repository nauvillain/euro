<?php
include 'auth_recipe.php';
session_name("recipes");
session_start();
$_SESSION['manage_recipe']=3;
header("Location:".$_SERVER['HTTP_REFERER']);
?>
