<?php
function __autoload($class_name) {
    include 'class/'.$class_name . '.class.php';
}
