<?php

require 'php_header.php';
?>
<div id='foot_main'>
<?php
function get_3rd_place_groups($letter){
	global $big_euro_3rd_place;

	$corr=array("A"=>0,"B"=>1,"C"=>2,"D"=>3);
	$num_col=$corr[$letter];
	$col=array_unique(array_column($big_euro_3rd_place,$num_col));
	asort($col);
	$str="";
	foreach ($col as $key=>$value){
		$str=$str.$value;
	}
	//print "groups are $str";
	print_r($col);	
return($str);
}

$third_place_groups=get_3rd_place_groups("B");
echo "this is 3rd_place_groups for B:$third_place_groups ";

?>

</div>
<?php

require 'foot_foot.php';
?>
