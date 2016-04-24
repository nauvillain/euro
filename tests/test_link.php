<?php
function urltolink($wdata){ 

    while (strpos($wdata, "http")) { 

    $op=strpos($wdata, "http"); 
    $rdata=substr($wdata, 0, $op); 
    $ndata=substr($wdata, $op, strlen($wdata)-$op); 
    
    preg_match('@^(?:http://)?([^/]+)@i',
    $ndata, $matches);
$link= $matches[1];
echo "link".$link;
//$link=substr($ndata, 0, $cp); 
    $oc=$op+$cp; 
    $wdata=substr($wdata, $oc, strlen($wdata)-$oc); 
    
    $edata=$edata."$rdata <a href=\"$link\">$link</a><br />"; 
    } 
    return $edata; 
} 

function link_length($ndata){
	for($i=0; $i<strlen($ndata); $i++){
		$char=substr($ndata,$i,1);
		echo "char:".$char;
		if((!is_numeric($char))&&($char!="/")){
			$index = $i;
		break;
		}
	}
return $index;
}

$string= "the lazy dog jumps the  http://vilnico.homelinux.net barrier";
$string= preg_replace("/(http:\/\/[^\s]+)/", "<a href=\"$1\">$1</a>", $string);
//echo urltolink($string);
echo $string;?>
