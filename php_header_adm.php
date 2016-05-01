<?php

//authentication module
require 'auth_foot.php';
//global vars
require_once 'conf.php';
//general library functions
require 'lib_gen.php';
//specific library functions
require 'lib_foot.php';
connect_to_eurodb();
require_once 'admin.php';
//html header
require 'head_foot.php';
require 'javascript.php';
//menus
require 'header_foot.php';
?>
