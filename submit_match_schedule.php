<?php
require 'conf.php';
require 'config/config_foot.php';
require 'auth_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';
// Define post fields into simple variables
$id = $_POST['id'];
$match_date = $_POST['match_date'];
$match_time = $_POST['match_time'];
$team1 = $_POST['team1'];
$team2 = $_POST['team2'];
$place_id = $_POST['place_id'];

// Enter info into the Database.
connect_to_eurodb();
if($id<$fr_m+1) $first_round=1;
else $first_round=0;

if ($first_round){
	$res=mysqli_query($link,"SELECT group_name FROM teams WHERE team_id='$team1'");
	$str='1st Round - Group '.mysqli_result($res,0);
}
else $str="";


mysqli_query($link,"SET NAMES 'utf8'");
$res=mysqli_query($link,"SELECT id FROM matches where id='$id'");
if(mysqli_num_rows($res)) {
	if($first_round) $query="UPDATE matches SET t1='$team1', t2='$team2',date='$match_date',time='$match_time',place='$place_id',descr='$str' WHERE id='$id'";
	else $query="UPDATE matches SET t1='$team1', t2='$team2',date='$match_date',time='$match_time',place='$place_id WHERE id='$id'";
}
else	if($first_round) $query="INSERT INTO matches (t1,t2,date,time,place,id,descr) VALUES ('$team1','$team2','$match_date','$match_time','$place_id','$id','$str')";
	else $query="INSERT INTO matches (t1,t2,date,time,place,id) VALUES ('$team1','$team2','$match_date','$match_time','$place_id','$id')";
echo "query: $query <br>\n";
$sql = mysqli_query($link,$query) or mysqli_error($link);
header("location:enter_schedule.php?last_id=".$id);

?>
