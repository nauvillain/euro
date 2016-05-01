<?php
require 'php_header.php';
?>
<div id='main'>
<?php
$query="SELECT email FROM users ";
$res=mysql_query($query);
$num=mysql_num_rows($res);

for($i=0;$i<$num;$i++){

$email=mysql_result($res,$i,'email');

echo "$email ;";


}






require 'footer.php';
?>
