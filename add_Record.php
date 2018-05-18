<?php
require 'php_header.php';
require 'admin.php';
echo "<div id='foot_main'>\n";

// Define post fields into simple variables

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$city = $_POST['city'];
$username=$_POST['username'];
$password=$_POST['password'];
$nickname=$_POST['nickname'];
$sweet=$_POST['sweet'];
$zincou=$_POST['zincou'];
$player=$_POST['player'];
$email=$_POST['email'];
$contact=$_POST['contact'];

if($nickname==""){ echo "<p>You must enter a nickname!</p>";
		  echo "<br><br><a href='javascript:history.back()'>Back</a>";
}
else{
	// Enter info into the Database.
	connect_to_eurodb();
	$query="SELECT * FROM users WHERE (nickname= '$nickname' OR username='$username') AND player=1";
	$rez=mysqli_query($link,$query) or mysqli_error($link);
	$num=mysql_num_rows($rez);
	if($num==0){
		$query="INSERT INTO users SET first_name=\"$first_name\",last_name=\"$last_name\", nickname=\"$nickname\",city=\"$city\", username=\"$username\", password=password(\"$password\"), sweet=\"$sweet\", zincou=\"$zincou\", player=\"$player\",email=\"$email\", contact='$contact' ";

		//echo "query: $query <br>\n";
		$sql = mysqli_query($link,$query);
		if(!$sql){
			echo 'There has been an error updating the
			changes. Please contact the webmaster.';
		} 
	else {
	     echo "The user ".$username." (".$nickname." from ".$city."), password: $password  has been added.<br>https://worldcup.homeip.net/";
	     }
	}
	else{
		echo "This nickname is already taken! Please choose another one";
		echo "<br><br><a href='javascript:history.back()'>Back</a>";
	}
}
require 'foot_foot.php';
?>

