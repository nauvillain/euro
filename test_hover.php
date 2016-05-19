<?php
require 'php_header.php';
//require 'header_forum.php';
require 'lib_forum.php';


echo "<script type='text/javascript'>
var replystr='".get_word_by_id(105)."';
var newthreadstr='".get_word_by_id(96)."';
</script>\n";
echo "<script type='text/javascript' src='js/sarissa.js'>\n";
echo "</script>\n";
echo "<script type='text/javascript' src='js/forum.js'>\n";
echo "</script>\n";
connect_to_eurodb();
echo "<script type='text/javascript' src='js/domcollapse.js'></script>\n";
echo "<script type='text/javascript' src='js/likes_test.js'></script>\n";

echo "<div id='foot_main'>";
	echo "<div class='like_unlike'>\n";
		echo "<div id='post_2520'><p>13 2 4 </p>\n"; 
			echo "<input type='hidden' id='likes-2520' value='1'>\n";
			echo "<input type='hidden' class='forum_post_id' value='2520'>\n";
			echo "<input type='hidden' class='like_type' value='like'>\n";
		?>
			<div class="btn-likes"><input type="button" title="<?php echo ucwords($str_like); ?>" class="<?php echo $str_like; ?>" onClick="addLikes(<?php echo $id; ?>,'<?php echo $str_like; ?>')" /></div>
			<div class="label-likes">
	<div class="desc"></div>
			</div>

	</div>
</div>

