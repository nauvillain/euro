<?php
require 'conf.php';
require 'php_header.php';

connect_to_eurodb();
function parent_chain($id){
//creates an array consisting of all the contacts
//..until the admin_id contact, who is connected to all users ultimately
global $admin_id;
$stack=array();
//loop until it finds the admin_id
do {
	$query="SELECT contact FROM users WHERE id='$id'";
	$res=mysql_query($query) or die(mysql_error());
	$id=mysql_result($res,0);
	array_push($stack,$id);
} while ($id!=$admin_id);

return $stack;
}
function create_shortest_chain($id1,$id2){
//returns an array consisting of the shortest chain of contact between id1 and id2
	$stack1=parent_chain($id1);
	$stack2=parent_chain($id2);

	if ($id1==$id2) return 0;
//find the shortest parent_chain
//Compare the last 2 elements of each. If they have identical last elements and different second elements, stop the counter.
	do {
		$last1=array_pop($stack1);
		$last2=array_pop($stack2);
	} while (!(($last1==$last2)&&(end($stack1)!=end($stack2)))); 
//the common parent element (that is the lowest in the tree) is $last1
//construct the chain
	$stack1[]=$last1;
	$reverse2=array_reverse($stack2);
return(array_merge($stack1,$reverse2));
}

function contact_chain($id1,$id2){
$test=create_shortest_chain($id1,$id2);
while (list($key,$val)=each($test)){
	$test2[]=get_username($val);
}
$test3=array();
array_push($test3,get_username($id1),$test2,get_username($id2));
return($test3);	
}

?>
<div id='main'>
<?php
?>

</div>
<?php
require 'foot_foot.php';
?>
