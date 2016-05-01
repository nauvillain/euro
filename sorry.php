<?php
require 'php_header.php';
require 'javascript.php';
?>
<div id='main'>
<div class='middle'>

<form name="form1" method="post" action="login1.php">
  <p><h3><b>Access unauthorized</b></h3></p>
  <p>Username/password is wrong or there is no user with this
  username. Please try again.</p>
  <table cellspacing="0" cellpadding="0" height="67" border=0 width='250' align='center'>
    <tr> 
      <td><b>Username</b></td>
      <td> 
        <input type="text" name="username">
      </td>
    </tr>
    <tr> 
      <td><b>Password</b></td>
      <td> 
        <input type="password" name="password">
      </td>
    </tr>
  </table>
  <p><b><br>
    <input type="submit" name="Submit" value="Login">
    </b></p>
</form> 
</div>
<br><br>

<?php 
require 'foot_foot.php';
?>
