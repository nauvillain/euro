<?php

//authentication module
require 'auth_foot.php';
require 'conf.php';
require 'config/config_foot.php';
require 'session_language.php';
//global vars
//general library functions
require 'lib/lib_gen.php';
//specific library functions
require 'lib_foot.php';
connect_to_eurodb();
//html header
require 'head_foot.php';
require 'javascript.php';
//menus
require 'header_foot.php';
require 'class/autoload.php';
$DB = DB::Open();
?>
