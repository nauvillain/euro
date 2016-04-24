<?php
require 'config_recipe.php';
session_register('error');
session_register('msg');

function mysql_die(){
	echo mysql_error();
}

function connect_to_recipe_database()
{
  global $dbr_database, $dbr_username, $dbr_password, $dbr_hostname;
  mysql_pconnect($dbr_hostname,$dbr_username,$dbr_password) or mysql_die();
  mysql_select_db($dbr_database) or mysql_die();
}

function set_language($lg){
	$_SESSION['language']=$lg;
}

function set_error($err) {
$error=$err;
}

function set_msg($mess){
$msg=$mess;
}

function include_css($path) {
echo "<link rel='stylesheet' type='text/css'
href='$path' />";
}
			
function display_recipe_field($display_name,$field,$size,$class,$value) {
echo "<label for='$field' class='$class'>".utf8_decode($display_name)."</label>\n";
echo "<input name='$field' size='$size' type='text' id='$field' value='$value' /><br/>\n";

}
function display_recipe_area($display_name,$field,$cols,$rows,$class,$value) {
echo "<label for='$field' class='$class'>$display_name</label>\n";
echo "<textarea name='$field' cols='$cols' rows='$rows' type='text' id='$field' >$value</textarea><br/>\n";

}
function display_recipe_list($display_name,$field_name,$mini,$maxi,$class,$val){
echo "$display_name \n ";
echo "<SELECT name='$field_name' id='$field_name' size=1>\n";
for($i=$mini;$i<$maxi+1;$i++) {
	echo "<OPTION ".($i==$val?"selected":"")." value='$i'>$i</option>\n";
}
echo "</SELECT>";

}
      
function display_combo_list($db,$table1,$table2,$common1,$common2,$name1,$name2,$label1,$label2,$existing_id,$lang){
//table2 is the look-up table: display the corresponding entries to the selected option for table1
//displays 2 combo boxes and displays the 
//requires 'javascript_combo.php' for dynamic handling.
echo "<label  style='float:left;' for='stage1'>$label1</label>\n";
echo "<select name='stage1' style='float:right;' size='1' onChange='redirect(this.options.selectedIndex)'>\n";

$name1=$name1."_".$lang;
$name2=$name2."_".$lang;

//select all entries from table 1

$query="SELECT * FROM $db.$table1 ORDER BY $name1";
$res=mysql_query($query);
$num_items1=mysql_num_rows($res);

//select name and correspondance column from existing data

if($existing) {	
			$exi=mysql_query("select * from $table1 where id=$existing_id");
			$existing_name=mysql_result($exi,0,$name1);
			$existing_code=mysql_result($exi,0,$common1);
}
else {
			$existing_name=mysql_result($res,0,$name1);
			$existing_code=mysql_result($res,0,$common1);
}	

if(!$existing_id) $existing_id=mysql_result($res,0,'id');
for($i=0;$i<$num_items1;$i++){
	$items1[$i]=mysql_result($res,$i,$name1);
	$code[$i]=mysql_result($res,$i,$common1);
	$idd[$i]=mysql_result($res,$i,'id');
	echo "<option ".($existing_id==$idd[$i]?'selected':'')." value=".$idd[$i].">".$items1[$i]."</option>\n";
}

echo "</select><br>\n";
echo "<label  style='float:left;' for='stage2'>$label2</label>\n";
echo "<select style='float:right'; name='stage2' size=1>\n";

//display the unit

$query="SELECT * FROM $db.$table2 WHERE ($common2='$existing_code')";
$resa=mysql_query($query);
$num_items2=mysql_num_rows($resa);


for($i=0;$i<$num_items2;$i++){
	$tsc[$i]=mysql_result($resa,$i,$name2);
	$idd[$i]=mysql_result($resa,$i,'id');
	if (!$tsc[$i]) $tsc[$i]=mysql_result($resa,$i,'unit');
	echo "<option ".($i==0?"selected":"")." value='$idd[$i]'>".utf8_encode($tsc[$i])."</option>\n";
}
echo "</select><br>\n";
?>
<script type="text/javascript">
<!--

var groups=document.form1.stage1.options.length
var group=new Array(groups)
	for (i=0; i<groups; i++) group[i]=new Array();
	
<?php
	for($i=0;$i<$num_items1;$i++){
		//option '3' is just for the recipes. Can be parameterized if needed.
		$query="SELECT * from $db.$table2  WHERE ($common2='".$code[$i]."' or $common2='3')";
		$resc=mysql_query($query) ;
		if($resc) $num_items=mysql_num_rows($resc);
		else $num_items=0;
	for($j=0;$j<$num_items;$j++){
			$sc_name=mysql_result($resc,$j,$name2);
			if(!$sc_name) $sc_name=mysql_result($resc,$j,'unit');
			$sc_id=mysql_result($resc,$j,'id');
			echo "group[$i][".($j+0)."]=new Option(\"".utf8_encode($sc_name)."\",'$sc_id');\n";
		}	
	}
?>

var temp=document.form1.stage2
	
//-->
</script>
<?php
}

function disp_col($col,$label,$manage) {
	echo "<td align='center'><font color='green'><b><a href='list_recipes.php?order=".$col.($manage?"&manage=$manage":"")."'>".$label."</a></b></font></td>\n";
}
function get_word($language,$english_word) {
//gets a word according to the set language session variable ; based on the english word
	$la_q="SELECT word_".$language." FROM recipes.language WHERE LOWER(word_en) LIKE LOWER(\"".utf8_encode($english_word)."\")";
	$la=mysql_query($la_q) or die(mysql_error());
/*	
	if($english_word=="all recipes") {
		echo $la_q;
		exit;
	}
*/
	return mysql_result($la,0,0);
	
}

function get_recipe_id($main,$language) {
	$te=mysql_query("SELECT id_".$language." FROM recipes.main WHERE id=$main");
	return mysql_result($te,0,0);

}
				

function display_recipe_db_list($display_name,$field_name,$table,$class,$tbl_field,$value) {
$q="SELECT id,$tbl_field FROM $table ORDER BY $tbl_field";
$query=mysql_query($q);
$num=mysql_num_rows($query);
//echo $q;
echo "$display_name<br/>";
	echo "<select name='$field_name' id='$field_name' class='$class'>\n";
	for($i=0;$i<$num;$i++){
		$id=mysql_result($query,$i,'id');
		$name=mysql_result($query,$i,$tbl_field);
		echo "<option ".($id==$value?"selected":"")." value='$id'>".utf8_encode($name)."</option>\n";
	}
	echo "</select>\n";

}

function get_field($table,$field,$id) {

	$query=mysql_query("select $field from $table where id=$id");
	return mysql_result($query,0);

}
function get_headers_cat($language) {
	//generate headers for existing recipes
	
	
	$query_types=mysql_query("SELECT DISTINCT type FROM recipes.main") or mysql_die();
	$num_types=mysql_num_rows($query_types);
	for($i=0;$i<$num_types;$i++) {
		$type_id=mysql_result($query_types,$i,'type');
		$type_name=mysql_result(mysql_query("SELECT name_".$language." FROM recipes.type WHERE type_id=$type_id"),0);
		echo "<p><a href='list_recipes.php?type=$type_id'>".ucfirst(utf8_encode($type_name))."</a></p>\n";
	}	
}

?>
