<?php
	require_once 'php_header.php';
	require_once 'lib/xml_lib.php';
// array :
//0: title
//1: heading
//2: rss url
//3: num_items
//4:utf8;
echo "<div id='foot_main'>\n";

	function news_div($arr,$num_col){
			echo "<div id='news".$num_col."'>";
				for ($i=0;$i<sizeof($arr);$i++){
					echo "<div class='trigger'>\n
					".$arr[$i][0]."</div>\n
					<div  class='enews'>\n
					<div class='news_column'>".$arr[$i][1]."</div>\n";
					if($arr[$i][4]) while(display_xml_utf8($arr[$i][2],$arr[$i][3]));
					else while(display_xml($arr[$i][2],$arr[$i][3]));
					echo "</div>\n";
				}
			echo "</div>\n";
	
}

	$arr1[0]=array("Euro 2012",'',"http://rsslivescores.com/RssTestFeed.aspx",10,1);
	news_div($arr1,1);

echo "</div>";
