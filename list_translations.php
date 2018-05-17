<?php
require 'php_header.php';
require_once 'session_language.php';

echo "<div id='foot_main'>";
echo "<b style='position:relative;font:bold 18px arial,helvetica,sans-serif;width:300px;height:50px;margin:0 auto;'>List of translations</b>";
if(is_admin($login_id)) $sweet=1;

if(isset($_POST['search'])) $search=$_POST['search'];
else $search="";

connect_to_eurodb();
//check if the user has the right to manage movies
global $link;

if($sweet) {
	echo "<div style='float:right;'><a href='enter_translations.php'>Add a translation </a></p></div>";
}

if(!$sweet) {
	echo "<br/>You are not allowed to manage translations. Sorry! :)";
exit;
}
else{

	mysqli_query($link,"SET NAMES 'utf8'");
	$result=mysqli_query($link,"select count(*) from language");
	$num=mysqli_result($result,0);
	if (!isset($order)) $order="word_en";
	if (!isset($search)) $search="";
	if (!isset($manage)) $manage="";
	$query="SELECT * from language where (word_en like '%$search%' or word_fr like '%$search%' or word_hu like '%$search%') order by $order";
	$result=mysqli_query($link,$query);
	$num=mysqli_num_rows($result);
	echo "<div id='simple_form'>\n";
	echo "<table><tr><td><form method=post action='list_translations.php?manage=$manage&order=$order'>\n</td><td><input type=text size=45 name=search id=search value=''>&nbsp;</td><td>&nbsp;<input type='submit' value='search' class='submit' /></td></tr></table><br>\n";
	echo "</div>\n";
	echo "<div id='list_translations'>\n";
	if (!$num) echo "Sorry, no ingredients match your request.<br>";
	if (($num)&&($search!="")) echo $num." ingredient".($num==1?"":"s")." match".($num==1?"es":"")." your request.<br>";
	echo "<table width=100% border=0  cellspacing=2   cellpadding=0>";
	
	//find the corresponding words for the column titles and display the rows
		echo "<td>ID</td>";

for($i=0;$i<sizeof($language_array);$i++) {
		$field='word_'.$language_array[$i];
		disp_col($field,get_word($language,$language_meta[$i]),$manage);
	}
	if($sweet){
		echo "<td>Edit</td>";
		echo "<td>Delete</td>";  
	}
	echo "</tr><tr>";
	for($i=0;$i<$num;$i++){
		
		$id=mysqli_result($result,$i,'id');
		echo "<td>$id</td>";
		for($j=0;$j<sizeof($language_array);$j++){
			$wordi=mysqli_result($result,$i,'word_'.$language_array[$j]);
			echo "<td><b>".$wordi."</b></td>\n";
		}
		
		if($sweet){
			echo "<td><a href='enter_translations.php?word_id=$id'><img alt='edit' src='b_edit.png' height=7px></a></td>\n";
			echo "<td><a href='delete_translations.php?word_id=".$id."' style='text-decoration:none;'><img src='b_drop.png' height=7px></a></td>\n";
		}
		echo "</tr>\n";
	}

}
echo "</table>\n";
echo "</div>\n";
echo "</div>";
echo "</div>";
echo "</body>
</html>";
