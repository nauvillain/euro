<?php
require 'auth_recipe_public.php';
require 'lib_gen.php';
require 'lib_docs.php';
gen_header('css/recipe.css');
require 'page_header.php';
require 'menu.htm';
require 'header_documents.php';
?>
<?php
//gather variables

$sweet=is_sweet($login_id);

$search=$_POST['search'];
$order=$_REQUEST['order'];


echo "<div id='list_recipes'>";
?>
<div id='recipe_list_title'>

<h3>Processed articles</h3>
</div>
<?php
if($sweet) {
	echo "<a href='new_publication.php'>New Article&nbsp;</a>\n";
}

connect_to_documents_database();


	$result=mysql_query("select count(*) from documents.publi");
	$num=mysql_result($result,0);
	echo "$num document".($num<2?"":"s")." in total<br>";
	if (!$order) $order="id";

	$query="SELECT id,authors,title,year,details,date_entered,summary,size,type FROM documents.publi WHERE title like '%".$search."%' ORDER BY $order DESC";
	$result=mysql_query($query) or mysql_die();
	$num=mysql_num_rows($result);
	echo "<div id='simple_form'>\n";
	echo "<form method='post' action='list_publications.php?order=$order'>\n";
	echo "<input type='text' size='45' name='search' id='search' value=''/>&nbsp;&nbsp;<input type='submit' value='Search' class='submit'/><br/>\n";
	echo "</form>\n";
	echo "</div>\n";
	if (!$num) echo "Sorry, no documents match your request.<br><a href='list_publications.php?order=$order'>List all documents</a><br/>";
	if (($num)&&($search!="")) echo $num." document".($num<2?"":"s")." match".($num==1?"es":"")." your request.<br/>";
	echo "<table width='100%' > \n";


	echo "<tr>\n<td><font color='black'></font></td>\n";
	echo "<td><font color='green'><b>download</b></font></td>\n";
	echo "<td><font color='green'><b><a href='list_publications.php?order=authors'>Authors</a></b></font></td>\n";
	echo "<td><font color='green'><b><a href='list_publications.php?order=title'>Title</a></b></font></td>\n";
	echo "<td><font color='green'><b><a href='list_publications.php?order=year'>Year</a></b></font></td>\n";
//	echo "<td><font color='green'><b>Details</b></font></td>\n";
	echo "<td><font color='green'><b>summary</b></font></td>\n";
	echo "<td><font color='green'><b><a href='list_publications.php?order=size'>size</a></b></font></td>\n";
//	echo "<td><font color='green'><b><a href='list_publications.php?order='type'>type</a></b></font></td>\n";
	echo "<td><font color='green'><b><a href='list_publications.php?order=date_entered'>Upload date</a></b></font></td>\n";
	//disp_col('Comments',get_word($language,'Comments'),$manage);
	if($manage){
		echo "<td>Manage</td>\n";  
		echo "<td>Delete</td>\n";  
	}
	echo "</tr>\n";
	while(list($id,$authors,$title,$year,$details,$date_entered,$summary,$size,$type)=mysql_fetch_array($result)){
		$size_f=filesize_format($size);

		echo "<tr>\n<td><font color='black'>&nbsp;</font></td>\n";
		echo "<td><font color='black'>".($size?"<a href='download_publication.php?id=$id' style='text_decoration:none;'><img src='run_on.gif'/>":"<a href='upload_file_pub.php?id=$id'>upload")."</a>&nbsp;</font></td>\n";
		echo "<td><b>".$authors."</b></td>\n";
		echo "<td><b><a href='display_publication.php?id=$id' style='color:black;'>".$title."</a></b></td>\n";
		echo "<td><b>".$year."</a></b></td>\n";
//		echo "<td><b>".$details."</a></b></td>\n";
		echo "<td>".substr($summary,0,90)."...</td>\n";
		echo "<td>$size_f</td>\n";
//		echo "<td><b>".$type."</a></b></td>\n";
		echo "<td>&nbsp;".substr($date_entered,0,10)."</td>\n";
		if($sweet){
			echo "<td><a href='edit_publication.php?id=".$id."' style='text-decoration:none;'><img src='b_edit.png' alt='Edit' height=10px></a></td>\n";
			echo "<td><a href='delete_publication.php?id=".$id."' style='text-decoration:none;'><img src='b_drop.png' alt='Delete' height=10px></a></td>\n";}
		echo "</tr>";
		}
	
echo "</table>\n";
echo "</div>\n";
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";
?>	
