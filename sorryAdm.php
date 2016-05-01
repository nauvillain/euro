<?php
require 'head.php';
require 'headerAdm.php';
require 'javascript.php';
?>
<TITLE>Access unauthorized</TITLE>
<br><br><br>
<form name="form1" method="post" action="login2.php">
<p><h3>Administrator section</h3></p>
<p><font size="2">Username/password for admin is wrong.</font></p>
  <table cellspacing="0" cellpadding="0" height="67" border=0>
    <tr> 
      <td><font size="2"><b>Log In</b></font></td>
      <td align=center> 
        <input type="text" name="username">
      </td>
    </tr>
    <tr> 
      <td><font size="2"><b>Password</b></font></td>
      <td align=center> 
        <input type="password" name="password">
      </td>
    </tr>
  </table>
  <p><b><br>
    <input type="submit" name="Submit" value="Login">
    </b></p>
</form>
<p><font size="1">
<a href="login.php"> Login as user </a>
</font></p>
<?php 
require 'footer.php';
?>
