<?php
//require 'config/config_foot.php';

function connect_to_database(){
  global $db_database, $db_username, $db_password, $db_hostname;
  mysql_pconnect($db_hostname,$db_username,$db_password) or mysql_die();
  mysql_select_db($db_database) or mysql_error();
}

function connect_to_database_blog(){
  global $db_database_blog, $db_username, $db_password, $db_hostname;
  mysql_pconnect($db_hostname,$db_username,$db_password) or mysql_die();
  mysql_select_db($db_database_blog) or mysql_error();
}

function gen_header($css_path) {
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
        \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html>
<head>
<title>Zita &amp; Nicolas' Website</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
<meta name=\"GENERATOR\" content=\"Mozilla/4.61 [en] (X11; I; Linux 2.2.9-23mdk i686) [Netscape]\"/>
<meta name=\"Author\" content=\"Nicolas Auvillain &amp; Zita Oravecz\"/>
<meta name=\"Description\" content=\"Very interesting things about us!\"/>
<meta http-equiv=\"X-UA-Compatible\" content=\"chrome=1\">
<meta name=\"keywords\" content=\"nicolas auvillain zita oravecz\"/>
<link rel=\"shortcut icon\" href=\"/frogi.gif\"/>
<link rel=\"stylesheet\" type=\"text/css\"
href=\"$web_path/css/menu.css\" />
<link rel=\"stylesheet\" type=\"text/css\"
href=\"".$css_path."\" />

<!--[if IE]>
<link rel=\"stylesheet\" type=\"text/css\"
href=\"css/menu_ie.css\" />
<![endif]-->
<!-- Background white, links blue (unvisited), navy (visited), red (active) --> </head>\n";
echo "<body>\n";



}
function gen_header_page($css_path,$title) {
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
        \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html>
<head>
<title>".$title." - Zita &amp; Nicolas' Website</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
<meta name=\"GENERATOR\" content=\"Mozilla/4.61 [en] (X11; I; Linux 2.2.9-23mdk i686) [Netscape]\"/>
<meta name=\"Author\" content=\"Nicolas Auvillain &amp; Zita Oravecz\"/>
<meta name=\"Description\" content=\"Very interesting things about us!\"/>
<meta name=\"keywords\" content=\"nicolas auvillain zita oravecz\"/>
<meta http-equiv=\"X-UA-Compatible\" content=\"chrome=1\">
<link rel=\"shortcut icon\" href=\"/frogi.gif\"/>
<link rel=\"stylesheet\" type=\"text/css\"
href=\"".$css_path."\" />

<!--[if IE]>
<link rel=\"stylesheet\" type=\"text/css\"
href=\"css/menu_ie.css\" />
<![endif]-->
<!-- Background white, links blue (unvisited), navy (visited), red (active) --> </head>\n";
echo "<body>\n";



}

function gen_header_full_ru($css_path,$title,$icon,$content,$keywords) {
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
        \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" >
<head>
<title>".$title." - Zita &amp; Nicolas' Website</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\"/>
<meta name=\"GENERATOR\" content=\"Mozilla/4.61 [en] (X11; I; Linux 2.2.9-23mdk i686) [Netscape]\"/>
<meta name=\"Author\" content=\"Nicolas Auvillain &amp; Zita Oravecz\"/>
<meta name=\"Description\" content=\"".$content."\"/>
<meta name=\"keywords\" content=\"".$keywords."\"/>
<meta http-equiv=\"X-UA-Compatible\" content=\"chrome=1\">

<link rel=\"shortcut icon\" href=\"/icons/".$icon."\"/>
<link rel=\"stylesheet\" type=\"text/css\"
href=\"".$css_path."\" />

<!--[if IE]>
<link rel=\"stylesheet\" type=\"text/css\"
href=\"css/menu_ie.css\" />
<![endif]-->
<!-- Background white, links blue (unvisited), navy (visited), red (active) --> </head>\n";
echo "<body>\n";



}


function is_sweet($login_id) {
connect_to_database();
	if($login_id) {
		$sweet_q=mysql_query("SELECT * FROM website.users WHERE sweet=1 AND users.id=$login_id");
		$sweet=mysql_num_rows($sweet_q);
	}
	else $sweet=0;
	return $sweet;
}
function is_friend($login_id) {
connect_to_database();
	if($login_id) {
		$sweet_q=mysql_query("SELECT * FROM website.users WHERE friend=1 AND users.id=$login_id");
		$sweet=mysql_num_rows($sweet_q);
	}
	else $sweet=0;
	return $sweet;
}

