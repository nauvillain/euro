<?php
require_once 'conf.php';
require_once 'config/config_foot.php';
//general library functions
require 'session_language.php';
require 'lib/lib_gen.php';
//specific library functions
require 'lib_foot.php';
connect_to_eurodb();
//html header
require 'head_foot.php';
require 'javascript.php';
//menus
require 'header_foot.php';
css('login.css');
	$url=$_REQUEST['url'];
?>
<div id='foot_main'>
<div id='login_content'>

<div id='main_login'>
<form  id="form1" method="post" action="login1.php?url=<?php echo $url;?>">
 <p>Please enter your username and password!</p>
  <table width=70% cellspacing="0" cellpadding="0" height="67" border=0 align=center>
    <tr> 
      <td><b>Username </b></td>
      <td> 
        <input type="text" name="username">

      </td>
    </tr>
    <tr> 
      <td>Password</td>
      <td> 
        <input type="password" name="password">
      </td>
    </tr>
  </table>
  <p><b>
    <input type="submit" name="Submit" value="Login">
 </p>
<p><input type="checkbox" name="public" value="false">&nbsp; click here if you are using a public/shared computer</p>
</form>
</div>
</div>
</div>
<?php
?>
