<?php

class arr{

	/***
	* arraySubSort, takes a multidimensional array and sorts it by values of $subkey using $sort function.
	* 
	* @param array    $array
	* @param string   $subkey
	* @param function $sort
	*/
	public static function sortArray($array, $subkey, $sort = asort) {
		  foreach($array as $key => $value) {
		    $temp[$key] = strtolower($value[$subkey]);
		  }
		  
		  $sort($temp);
		  foreach($temp as $key => $value) {
		    $result[] = $array[$key];
		  }
		  return $result;
	}		
}	

?>
