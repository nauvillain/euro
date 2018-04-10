<?php

class table{

	/***
	* Display a 2 dimensional array into a table, with a defined amount of rows 
	* Assumes the array is of the form:
	 array(
	  array('name' => 'Bob', 'age' => 27),
	  array('name' => 'Mary', 'age' => 22))
	*/
	
	
	public static function tableDisplay($data,$hide,$header_flag) {
	
	$userlink='player_profile.php?id=';
	
		$count=mysqli_num_fields($data);
	
		echo "\n\t<table>\n";
		//create header
		$arr=mysqli_fetch_array($data,MYSQLI_ASSOC);
		echo "\t<tr>\n";
		if(isset($arr)){
			foreach($arr as $key=>$val){
				if(!in_array($key,$hide)){
					if(($key=='current_ranking')||($key=='current_points')) echo "\t\t<td style='width:30px;'>";
					else echo "\t\t<td>";
					if($header_flag==1){
						$key=table::meta($key);
						echo $key;
					}
					if($header_flag==0) echo "&#9830";
					echo "</td>\n";
				}
			}
		}
		echo "\t</tr>\n";
			
	
	//reset pointer
		if(isset($data)) mysqli_data_seek($data,0); 
			
		while($arr=mysqli_fetch_array($data,MYSQLI_ASSOC)){
			echo "\t<tr>\n";
			foreach($arr as $key=>$val){
				if($key!='id'){
					echo "\t\t<td>";
					if($key=='nickname') echo "<a href='".$userlink.$id."'>";
					if($key=='current_points') echo round($val,2);
					else echo utf8_encode($val);
					if($key=='nickname') echo "</a>";
					echo "</td>\n";
				}
				else $id=$val;
//				if($key=='current_ranking' && $val=='3') echo '</tr><tr>\n';
			}
			echo "\t<tr/>\n";
		}
		echo "</table>\n";
	}

	public static function meta($key){
		global $column_meta;	
		if(array_key_exists($key,$column_meta)) $key=$column_meta[$key];
		return($key);
	}

	public static function smallTableDisplay($data,$hide,$array) {
	
	$userlink='player_profile.php?id=';
		 $count=mysql_num_fields($data);
	
		echo "\n\t<table>\n";
		echo "\t<tr/>\n";
			
	
	//reset pointer
		mysql_data_seek($data,0); 
			
		while($arr=mysql_fetch_array($data,MYSQLI_ASSOC)){
			echo "\t<tr>\n";
			foreach($arr as $key=>$val){
				if($key!='id'){
					echo "\t\t<td>";
					if($key=='nickname') echo "<a href='".$userlink.$id."'>";
					echo utf8_decode($val);
					if($key=='nickname') echo "</a>";
					echo "</td>\n";
				}
				else $id=$val;
			}
			echo "\t<tr/>\n";
		}
		echo "</table>\n";
	}

}	
?>
