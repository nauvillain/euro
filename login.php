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
//css('login.css');
	$url=$_REQUEST['url'];
?>
<div id='login_content'>

<div id='main_login' class="middle">
<form  id="form1" method="post" action="login1.php?url=<?php echo $url;?>">
 <p>Please enter your username and password!</p>
	  <div class="line">
		<div class='login'>
			Username
		</div>
		<div class='login'>
			<input type="text" name="username" class="left login big centre"/>
		</div>
	  </div>
	  <div class="line">
        <div class='login'>
			Password
		</div>
	    <div class='login'>
			<input type="password" name="password" class="left login big centre"/>
		</div>
	  </div>
	  <div class="line">
	    <div class='login right'>
			<input type="submit" name="Submit" value="Login" class="left login right">
		</div>
	  </div>
	  
</form>
</div>
</div>
