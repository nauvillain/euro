<?php

class RSSParser {

	var $insideitem = false;
	var $tag = "";
	var $title = "";
	var $description = "";
	var $link = "";
	var $counter=0;
	var $css='';

	function startElement($parser, $tagName, $attrs) {
		if ($this->insideitem) {
			$this->tag = $tagName;
		} elseif ($tagName == "ITEM") {
			$this->insideitem = true;
			$this->counter+=1;
		}
		
	}

	function endElement($parser, $tagName) {
		if ($tagName == "ITEM") {
			$id=rand(1,10000000);
			echo "<div style='padding:5px 0 5px 0;'><div  id='t_".$id."' name='t_".$id."' class='trigger'>\n  <div class='news_item_title'> ".trim($this->title)."</div>\n
	</div>\n";
			echo "<div id='c_".$id."' name='c_".$id."'>".strip_tags(trim($this->description))."\n";
			echo "<a href='".trim($this->link)."' target='rss'>more...</a>\n";
			echo "</div>\n</div>";
			$this->title = "";
			$this->description = "";
			$this->link = "";
			$this->insideitem = false;
		}
	}

	function characterData($parser, $data) {
		if ($this->insideitem) {
		switch ($this->tag) {
			case "TITLE":
			$this->title .= $data;
			break;
			case "DESCRIPTION":
			$this->description .= $data;
			break;
			case "LINK":
			$this->link .= $data;
			break;
		}
		}
	}
}

function display_xml($url,$count){

	$end=0;
	$xml_parser = xml_parser_create();
	$rss_parser = new RSSParser();
	if(isset($css)) $rss_parser->css=$css;
	xml_set_object($xml_parser,&$rss_parser);
	xml_set_element_handler($xml_parser, "startElement", "endElement");
	xml_set_character_data_handler($xml_parser, "characterData");
	$fp = fopen($url,"r")
		or die("Error reading RSS data.");
	while (($data=utf8_encode(fread($fp,4096)))&&!$end)
		if($rss_parser->counter<$count) {
			xml_parse($xml_parser, $data, feof($fp))
				or die(sprintf("XML error: %s at line %d", 
							xml_error_string(xml_get_error_code($xml_parser)), 
							xml_get_current_line_number($xml_parser)));
		}
		else $end=true;
	fclose($fp);
	xml_parser_free($xml_parser);
}
function display_xml_utf8($url,$count){

	$end=0;
	$xml_parser = xml_parser_create();
	$rss_parser = new RSSParser();
	if(isset($css)) $rss_parser->css=$css;
	xml_set_object($xml_parser,&$rss_parser);
	xml_set_element_handler($xml_parser, "startElement", "endElement");
	xml_set_character_data_handler($xml_parser, "characterData");
	$fp = fopen($url,"r")
		or die("Error reading RSS data.");
	while (($data=fread($fp,4096))&&!$end)
		if($rss_parser->counter<$count) {
			xml_parse($xml_parser, $data, feof($fp))
				or die(sprintf("XML error: %s at line %d", 
							xml_error_string(xml_get_error_code($xml_parser)), 
							xml_get_current_line_number($xml_parser)));
		}
		else $end=true;
	fclose($fp);
	xml_parser_free($xml_parser);
}
function display_xml_w($url,$count){

	$end=0;
	$xml_parser = xml_parser_create();
	$rss_parser = new RSSParser();
	$rss_parser->css=$css;
	xml_set_object($xml_parser,&$rss_parser);
	xml_set_element_handler($xml_parser, "startElement", "endElement");
	xml_set_character_data_handler($xml_parser, "characterData");
	$fp = fopen($url,"r")
		or die("Error reading RSS data.");
	while (($data=utf8_encode(fread($fp,4096)))&&!$end)
	if($rss_parser->counter<$count) {
			xml_parse($xml_parser, $data, feof($fp))
				or die(sprintf("XML error: %s at line %d", 
							xml_error_string(xml_get_error_code($xml_parser)), 
							xml_get_current_line_number($xml_parser)));
		}
		else $end=true;
	fclose($fp);
	xml_parser_free($xml_parser);
}

?>
