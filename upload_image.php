<?php
require 'php_header.php';
?>
<div id='foot_main'>
<p>This upload feature only works with JPG files with a jpg or jpeg extension.</p>
<form action="<?php echo $_SERVER['PHP_SELF']."?uploaded=1"; ?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="1560000"> Upload Image: <input type="file" name="imgfile">
<font size="1">(Max image size: 1500K) &nbsp;</font>
<input type="submit" value="Upload Image">
</form>
<?php
$imgfile=$_FILES['imgfile']['tmp_name'];
$imgname=$_FILES['imgfile']['name'];

$final_filename=$login_id.'_full.jpg';
$uploaded=$_REQUEST['uploaded'];

if($uploaded){

	if (is_uploaded_file($imgfile))
	{
	 $newfile = $uploaddir."/".$final_filename;
	   if (!copy($imgfile, $newfile)) 
		{
	       //if an error occurs the file could not
	       //be written, read or possibly does not exist
	      print "Error Uploading File. newfile: $newfile; oldfile=$imgfile";
	      exit();
	   }
	   
	}

	/*== where storing tmp img file ==*/
	$tmpimg = tempnam($tmp_uploaddir,"MKPH");
	$newfile = "$uploaddir/".$login_id.".jpg";
	$ext=substr($imgname,-strlen (strrchr($imgname,'.'))+1);

	/*== CONVERT IMAGE TO PNM ==*/
	if (strtolower($ext) == "jpg"||strtolower($ext)=="jpeg") { system("djpeg $imgfile >$tmpimg"); } 
	else { echo("Extension Unknown. Please only upload a JPEG image."); exit(); } 

	/*== scale image using pnmscale and output using cjpeg ==*/
	system("pnmscale -ysize 160 $tmpimg | cjpeg -smoo 10 -qual 70 >$newfile");
echo "Your image has been uploaded";
echo "<p><a href='index.php' style='float:right'>Main page</a></p>";
}

?>
