<?php
require 'php_header.php';
//needs netpbm, netpbm-progs, libnetpbm, libnetpbm-dev, libjpeg-progs 

?>
<div id='foot_main'>
<p>Note: This upload feature only works with JPG files with a jpg or jpeg extension.</p>
<form action="<?php echo $_SERVER['PHP_SELF']."?uploaded=1"; ?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="1560000"> Upload Image: <input type="file" name="imgfile">
<font size="1">(Max image size: 1500K) &nbsp;</font>
<input type="submit" value="Upload Image">
</form>
<?php
$imgfile=$_FILES['imgfile']['tmp_name'];
$imgname=$_FILES['imgfile']['name'];

$final_filename=$login_id.'_full.jpg';
$final_filename=$login_id.'.jpg';
$uploaded=$_REQUEST['uploaded'];



if($uploaded){

	switch ($_FILES['upfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

	if (is_uploaded_file($imgfile))
	{
	 $newfile = $uploaddir."/".$final_filename;
	   //if (!move_uploaded_file($imgfile, $newfile)) 
	   if (!copy($imgfile, $newfile)) 
		{
	       //if an error occurs the file could not
	       //be written, read or possibly does not exist
	      print "Error Uploading File. newfile: $newfile; oldfile=$imgfile user:".get_current_user();
	      exit();
	   }
	   else{
			echo "Image uploaded. <a href='player_profile.php?id=".$login_id."'> back </a>";
	   } 
	}

	$newfile1 = "$uploaddir/".$login_id.".jpg";
	/*== where storing tmp img file ==*/
	$tmpimg = tempnam($tmp_uploaddir,"MKPH");
	$ext=substr($imgname,-strlen (strrchr($imgname,'.'))+1);

//	copy($tmpimg,$newfile1);


	/*== CONVERT IMAGE TO PNM ==*/
/*	if (strtolower($ext) == "jpg"||strtolower($ext)=="jpeg") { system("djpeg $imgfile >$tmpimg"); } 
	else { echo("Extension Unknown. Please only upload a JPEG image."); exit(); } 

//	print_r($_FILES);
//	echo "login: $login_id ; $newfile";
	   echo "new_file".$newfile;*/
	/*== scale image using pnmscale and output using cjpeg ==*/
		/*system("pnmscale -ysize 160 $tmpimg | cjpeg -smoo 10 -qual 70 >$newfile");
echo "Your image has been uploaded. Make sure to refresh your profile page on the next visit.";
echo "<p><a href='index.php' style='float:right'>Main page</a></p>";
}
else {
//echo 'Here is some more debugging info:';
//print_r($_FILES);
		 */
}
?>
