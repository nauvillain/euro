<?php

//$arr=file('http://www.footballscores.com/fixtures-results/fixtures/international/euro/');
$arr=file_get_contents('http://www.scorespro.com/soccer/');
//$arr=file_get_contents('http://www.footballscores.com/fixtures-results/fixtures/international/euro/');
print_r($arr);
?>
