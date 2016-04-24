<?php
require 'php_header.php';
require 'javascript.php';
$match_id=$_REQUEST['id'];
?>
<script type="text/javascript">
<?php
            echo "window.location = 'change_bet.php?id=$match_id';";      // if scripting is active, go directly to home page.
    ?>
</script>
<div class='middle'>
You need to enable javascript, otherwise this page won't work properly.
Thanks!
</div>
<?
require 'foot_foot.php';
?>
