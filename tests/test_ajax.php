<?php
	require 'php_header.php';
	echo "<script type='text/javascript' src='sarissa.js'>\n";
	echo "</script>\n";
	require 'javascript_bets.php';
	echo "<script type='text/javascript' >\n";
	echo "function addPost(id) {
		var newPost = document.createElement('textarea');
		newPost.name = id+'_new';
		newPost.cols=70;
		newPost.rows=4;
		newPost.id = id+ '_new';
		thisDiv=document.getElementById(id);
		current_div=thisDiv.parentNode;
		current_div.replaceChild(newPost,thisDiv);
		var newLink=document.createElement('a');
		//newLink.href='#';
		newLink.onClick='load_new('+id+')';
		textLink=document.createTextNode('Submit');
		newLink.appendChild(textLink);
		newLink.className='ajax_link';
		current_div.appendChild(newLink);
		}
		";
	echo "function load_new(id){\n
		var xmlhttp = new XMLHttpRequest();\n;
		xmlhttp.open('GET','forum_post.php',true);\n
		xmlhttp.onreadystatechange = function() {\n
		if (xmlhttp.readyState == 1) {\n
				document.getElementById('test_new').innerHTML='loading...';
				}\n
		if (xmlhttp.readyState == 4) {\n
				document.getElementById('test_new').innerHTML=xmlhttp.responseText;
				}\n
		}\n";
	echo "xmlhttp.send(null);\n";
	echo "return false;\n";
		echo "}\n";

	echo "</script>\n";
	echo "<div id='main'>\n";
	echo "<div id='reply_thread'>\n";
	echo "<div id='test'>\n";
	echo "<a  class='ajax_link' onClick=\"javascript:addPost('test')\" >here";
	echo "</a>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "</div>\n";
	?>
