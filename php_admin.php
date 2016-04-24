<?php

//authentication module
require 'auth_foot.php';
require 'config/config_foot.php';
require 'conf.php';
require 'session_language.php';
//global vars
//general library functions
require 'lib/lib_gen.php';
//specific library functions
require 'lib_foot.php';
connect_to_eurodb();
//html header
require 'admin.php';
?>
