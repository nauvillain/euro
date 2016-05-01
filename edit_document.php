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
$id=$_REQUEST['id'];


echo "<div id='list_recipes'>";
?>
<div id='recipe_list_title'>

<h3>Add a document</h3>
</div>
<?php

connect_to_documents_database();

$query="SELECT title FROM documents.docs WHERE id=$id";
$res=mysql_query($query);
$title=mysql_result($res,0);


?>
<form method="post" action='edit_record_document.php'>
			<input name="id" type="hidden" id="id" value='<?php echo $id; ?>' >
  	<table align=center width="60%" border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td width=24% align="left" valign="top">Title
		</td>
      		<td width="76%"><input name="title" type="text" size=200  id="title" value="<?php echo $title;?>">
		</td>
	</tr>
  	</table>
			<input name="upload" type="submit"  id="upload" value=" Upload ">
</form>	

<?php

echo "</div>\n";
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";
?>	
