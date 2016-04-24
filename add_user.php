<?php
require 'authAdm.php';
require 'head.php';
require 'headerAdm.php';
require 'lib.php';
require 'javascript.php';
require 'javascript_form.php';
?>
<TITLE>Add a user - Euro 2004</TITLE>
<p><h4> Add a user</h4></p>

<form name="addRecord" method="post" action="add_Record.php"
  onsubmit='javascript:return validateForm(this)'>
  <table align=center width="60%" border="1" cellspacing="0" cellpadding="4">
    <tr> 
      <td width="24%" align="left" valign="top">Username</td>
      <td width="76%"><input name="username" type="text" id="username" value=""></td>
    </tr>
    <tr> 
      <td width="24%" align="left" valign="top">Password</td>
      <td width="76%"><input name="password" type="password" id="password" value=""></td>
    </tr>
<tr> 
      <td width="24%" align="left" valign="top">Nickname</td>
      <td width="76%"><input name="nickname" type="nickname" id="nickname" value=""></td>
    </tr>

    <tr> 
      <td width="24%" align="left" valign="top">First Name</td>
      <td width="76%"><input name="first_name" type="text" id="first_name" value=""></td>
    </tr>

    <tr> 
      <td align="left" valign="top">Last Name</td>
      <td><input name="last_name" type="text" id="last_name" value=""></td>
    </tr>
<tr> 
      <td align="left" valign="top">City</td>

      <td><input name="city" type="text" id="city" value=""></td>
</tr>
<tr> 
      <td align="left" valign="top">Manager</td>

      <td><input name="sweet" type="text" id="sweet" value="0"></td>
    </tr>
<tr>
<tr> 
      <td align="left" valign="top">email</td>

      <td><input name="email" type="text" id="email" value="0"></td>
    </tr>
<tr>
	<td align="left" valign="top">Zincou</td>
	<td><input name="zincou" type="text" id="zincou" value="0"></td>	
</tr>
<tr>
	<td align="left" valign="top">Player</td>
	<td><input name="player" type="text" id="player" value="0"></td>	
</tr>
<tr>
      <td align="left" valign="top">&nbsp;</td>
      <td><input type="submit" name="Submit" value="Add user"></td>

    </tr>
  </table>
</form>

<?php
require 'footer.php';
?>

