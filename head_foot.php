<?php

function gen_header_full($css_path,$title,$icon,$content,$keywords) {
header("Content-type: text/html; charset=utf-8");
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
        \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" >
<head>
<title>".$title."</title>
<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\"/>
<meta name=\"GENERATOR\" content=\"Mozilla/4.61 [en] (X11; I; Linux 2.2.9-23mdk i686) [Netscape]\"/>
<meta name=\"Author\" content=\"Nicolas Auvillain &amp; Zita Oravecz\"/>
<meta name=\"Description\" content=\"".$content."\"/>
<meta name=\"keywords\" content=\"".$keywords."\"/>
<meta http-equiv=\"X-UA-Compatible\" content=\"chrome=1\"/>
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js\"></script>
<link rel=\"shortcut icon\" href=\"/".$icon."\"/>\n";
require 'js/select_css.js';
//echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/menu_ie.css\" />
echo "<!-- Background white, links blue (unvisited), navy (visited), red (active) --> </head>\n";
echo "<body>\n";


}

gen_header_full("css/new_euro.css",$tournament_name,"favicon.ico",$tournament_name,"France Euro 2016");


?>
<div id="content">
<div id="pagetop" >
<a href="index.php">
<?php
echo $tournament_name;
?>
</a>
</div>

<?php
	require 'foot_general_info.php';
?>
