<?php
require 'authAdm.php';
require 'lib.php';
require 'head.php';
require 'headerAdm.php';


connect_to_database();

$res=mysql_query("SELECT * FROM teams where id<33 ORDER BY team_name");
$num=mysql_num_rows($res);


echo "
<form name='form1' method='post' action='submit_winner_adm.php'>";
echo "<select name='winner'>";
while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
echo "<option ".($row['winner']==1?'selected':'')." value=\"".$row['id']."\">".$row['team_name']."</option\n";
}
echo "
</select>
<input type=submit name='submit' type='submit' value='submit winner'>
</form>";




require 'footer.php';
?>
