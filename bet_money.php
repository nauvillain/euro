<?php
require 'auth.php';
require 'lib.php';
require 'head.php';
require 'header_foot.php';
require 'javascript.php';
require 'javascript_form.php';
require 'auth_guest.php';
require 'auth_bets1.php';

connect_to_database();
$result=mysql_query("SELECT bet_money FROM users  WHERE id='$login_id'") or mysql_die();
if(!mysql_num_rows($result)){
    echo "Strange error: there is no user with this id anymore. Maybe you were deleted from the database\n";
    require 'footer.php';
    exit;
}
//$row=mysql_fetch_array($result);
$money=mysql_result($result,0,'bet_money');
?>
<h2> Choose whether you want to bet money</h2>
<p> If you do, you must make sure that there is someone that can give you money/get money from you and that has a <a href='http://www.paypal.com'>paypal account</a>. Setting up a paypal account is quick and easy. This account enables you to make international payments and you can easily transfer money to/from your bank account.
</p>
<p><b>Please</b> make sure you filled in the 'Country' field in 'Edit my profile' so that we can know who must give to whom.</p>
<p><b>The transactions will be performed at the end of the World Cup - it is simpler that way! Also, the winner will get 60% of the pot, the second 30% and the 3rd 10%.</b></p>
<form name="form1" method="post" action="submit_bet_money.php"
  onsubmit='javascript:return validateFormUser(this)'>
  <table width="60%" border="0" cellspacing="0" cellpadding="4">
    <tr> 
      <td valign="top">I want to bet money (10 euros)</td>
      <td><input name="checkbox" type="checkbox" id="checkbox" value=1 <? echo ($money==1?"checked='checked'":""); ?>></td>
    </tr>

    <tr>
      <td valign="top">&nbsp;</td>
      <td><input type="submit" name="Submit" value="Submit changes"></td>

    </tr>
  </table>
</form>
<h3>List of 'contacts' for transactions (so far): <ul><li>Stefan(Sweden)
<li>Nicolas(Belgium)</ul></h3>

<?php
require 'footer.php';
?>








