<?php
require 'auth.php';
require 'lib.php';

$count=0;
$SR_M=16;
$FR_M=48;

connect_to_database();

$query="DELETE FROM bets WHERE player_id=$login_id AND match_id>$FR_M";
$sql=mysql_query($query) or mysql_die();

while(list($key,$val)=each($_POST)){

	
    $$key = $val;
//    echo "key:".$key."<br>";
  //  echo "val:".$val."<br>";

if(($val!="")&&($key!='Submit')){

  $count++;
  $s=substr($key,5,1); //takes the character after the 5th one
  $id=substr($key,6); //takes the characters after the 6th one
  $id=$id+$FR_M;
  //echo "valid key:".$key."<br>";
  $query="SELECT * FROM bets WHERE match_id='$id' AND player_id='$login_id'";
  //echo $query."<br>";
  $sql=mysql_query($query) or mysql_die;
  $tot=mysql_num_rows($sql);
  if(!$tot){
    $query="INSERT INTO bets SET goals_team$s=$val,match_id='$id',player_id='$login_id'";
    //echo $query."<br>";
    $sql=mysql_query($query) or mysql_die();
  }

  else{
    $query="UPDATE bets SET goals_team$s=$val WHERE match_id='$id' AND player_id='$login_id'";
    $sql=mysql_query($query) or mysql_die();
    }
    if(!$sql){
    echo 'There has been an error updating the changes. Please contact the webmaster.';
}
    //echo $query."<br>\n";
} 
unset($sql);
}

$test=2*$SR_M;

if ($count==$test){
  $query="UPDATE users  SET bets_phase2=1 WHERE id='$login_id'";
  $sql=mysql_query($query) or mysql_die();
}
else{
  $query="UPDATE users  SET bets_phase2=0 WHERE id='$login_id'";
  $sql=mysql_query($query) or mysql_die();
}
header("Location:bets2_saved.php");
?>
