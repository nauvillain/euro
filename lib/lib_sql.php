<?php

function display_table($table,$border){
$sql = "select * from $table";
$fields = mysql_query( $sql ) or die(mysql_error());
echo "<table border=\"$border\">\n";
$flag=0;
$num_fields=mysql_num_fields($fields);
echo "<tr>\n";
for ($i=0;$i<$num_fields;$i++){
	$meta=mysql_fetch_field($fields,$i);
	echo "<td>".($meta->name)."</td>\n";
}
echo "</tr>\n";
while($row=mysql_fetch_array($fields, MYSQL_ASSOC)) {
			
	        echo "<tr>\n";
		while(list($key,$val) = each($row) ) {
				echo "<td>".$val."</td>\n";
		}
		echo "</tr>\n";
	}
echo "</table>\n";

}

function display_table_manage($fields,$border,$edit,$edit_file,$delete_file){
echo "<table border=\"$border\">\n";
$flag=0;
$num_fields=mysql_num_fields($fields);
echo "<tr>\n";
for ($i=0;$i<$num_fields;$i++){
	$meta=mysql_fetch_field($fields,$i);
	echo "<td>".($meta->name)."</td>\n";
	if($meta->primary_key) {
		$primary=$i;
		$primary_name=$meta->name;
		}	
}
		echo "<td>Edit</td>";
		echo "<td>Delete</td>";
echo "</tr>\n";
while($row=mysql_fetch_array($fields, MYSQL_ASSOC)) {
			
	        echo "<tr>\n";
		while(list($key,$val) = each($row) ) {
				echo "<td>".$val."</td>\n";
				if($key==$primary_name) $primary_id=$val;
		}
		echo "<td><a href='$edit_file?$primary_name=$primary_id' style='text-decoration:none;'><img src='/img/b_edit.png' alt='edit' height='10px'/>&nbsp;</a></td>";
		echo "<td><a href='$delete_file?$primary_name=$primary_id' onclick='return del()' style='text-decoration:none;'><img src='/img/b_drop.png' alt='delete' height='10px'/></a></td>";
		echo "</tr>\n";
	}
echo "</table>\n";
}
?>
