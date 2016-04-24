<?php
require 'php_header.php';
connect_to_eurodb();

$word_id= $_REQUEST['word_id'];

$word=get_word_array($word_id);


function field($label,$name,$record) {

    echo "<tr>\n";
    echo "<td width='24%' align='left' valign='top'>".$label."</td>\n";
    echo "<td width='76%'><input name='".$name."' type='text' id='".$name."' value=\"".utf8_decode($record)."\"></td>\n";
    echo "</tr>\n";


}
?>

<div id='foot_main'>
<p><h4> Add/Edit a translation</h4></p>

<form name="add_ingredient" method="post" action="add_translation_record.php"
  onsubmit='javascript:return validateForm(this)'>
  <table align=center width="60%" border="1" cellspacing="0" cellpadding="4">
	<?php
	for($i=0;$i<sizeof($language_array);$i++) field($language_meta[$i],"word_".$language_array[$i],utf8_encode($word[$i]));    
		
	?>
	<tr>
	      <td align="left" valign="top">ID</td>
	      <td><?php echo $word_id;?></td>

	</tr>

	<tr>
	      <td align="left" valign="top">&nbsp;</td>
	      <td><input type="submit" name="Submit" value="Add word"></td>

	</tr>
  </table>
	      <input type="hidden" name="id" id="id" value="<?php echo $word_id;?>">
</form>
</div>
<?php
?>
