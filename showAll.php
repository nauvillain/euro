<?php
require 'authAdm.php';
require 'head.php';
require 'header.php';
require 'lib.php';
require 'javascript.php';

// Query the database:


connect_to_database();
$query="SELECT
id,first_name,last_name,city,country,comments
FROM users ORDER BY id  ";
//echo "query: $query <br>\n";
$rez=mysql_query($query) or mysql_die();
$num=mysql_numrows($rez);
if($num){
 if($num==1){ 
 echo "<p>".$num." result found.</p>";}
 else {echo "<p>".$num." results found.</p>";}  
 echo "<table border='1'>\n";
 echo "<tr>\n";
 echo "<td>Last Name</td>\n";
 echo "<td>First Name</td>\n";
 echo "<td>Country</td>\n";
 echo "<td>City</td>\n";
 echo "<td>Comments</td>\n";
 echo "<td>&nbsp</td>\n";
 echo "<td>&nbsp</td>\n";
 echo "</tr>\n";
 $i=0;
 while($i<$num){
  
  $last_name=mysql_result($rez,$i,"last_name");
  $first_name=mysql_result($rez,$i,"first_name");
  $country=mysql_result($rez,$i,"country");
  $city=mysql_result($rez,$i,"city");
  $email=mysql_result($rez,$i,"email");
  $comments=mysql_result($rez,$i,"comments");
  $id=mysql_result($rez,$i,"id");

  echo "<tr>\n";
  echo "<td>$last_name</td>\n";
  echo "<td>$first_name</td>\n";
  echo "<td>$country</td>\n";
  echo "<td>$city</td>\n";
  echo "<td>$comments</td>\n";
  echo "<td><a href=\"editRecordAdm.php?login_id=".$id."\"> Edit
  </a></td>";
 /*  echo "<td><a
  href=\"javascript:openwin('deleteRecordAdm.php?login_id=".$id."',600,400)\"> Delete </a></td>";*/
  echo"<td><a href=\"deleteRecordAdmSA.php?login_id=".$id."\"> Delete </a>";

  echo "</tr>\n";

++$i;
 }
 }
 else {
 echo "No records found, sorry!<br>";
 }
echo "<a href=\"adManage.php\">Back to main page</a>";
?>
<?php
require 'footer.php';
?>
