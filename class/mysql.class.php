<?php

class mysql{

	public static function createArray($result) {
		$values = array();
		for ($i=0; $i<mysql_num_rows($result); ++$i)
			array_push($values, mysql_result($result,$i));
		return $values;
		}	
		
}	

?>
