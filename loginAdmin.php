<?php
require 'head.php';
require 'headerAdm.php';
require 'javascript.php';
?>

<TITLE>Database Administrator Login Page</TITLE>
<br><br><br>
<form name="form1" method="post" action="login2.php">
 <p><h3>Administrator section</h3></p> 
 <p><font size="2">Please enter your username and password.</font></p>
  <table cellspacing="0" cellpadding="0" height="67" border=0>
    <tr> 
      <td><font size="2"><b>Username</b></font></td>
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
</form>
<br><br>
<font size=1>
<a href="login.php"> Login as user </a></font>
<?php
require 'footer.php';
?>
