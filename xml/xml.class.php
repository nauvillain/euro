<?php
//	require_once 'lib_gen.php';
//	require_once 'lib_xml.php';
class xmlScore {
	var $team1,$team2,$g1,$g2,$type,$desc,$pubdate;

	function set_team1($var){
		$this->team1=$var;
	} 
	function set_team2($var){
		$this->team2=$var;
	} 
	function set_g1($var){
		$this->g1=$var;
	} 
	function set_g2($var){
		$this->g2=$var;
	} 
	function set_type($var){
		$this->type=$var;
	} 
	function set_desc($var){
		$this->desc=$var;
	} 
	function set_pubdate($var){
		$this->pubdate=$var;
	} 
	function __construct($var){
	//score is of the form: Soccer Livescore: (CBL-CL) #Cruz Azul (MEX) vs #Dep. Tachira (VEN): 1-0
	//split the string into 3 elements separated by #
		if($var) {
		$exp=explode('#',$var['title']);	
	//get first team
		$team1=substr($exp[1],0,strpos($exp[1],"vs"));
		$this->set_team1($team1);
	//get second team
		$team2=substr($exp[2],0,strpos($exp[2],':'));

		$this->set_team2($team2);
	//split the score string to get g1 and g2
		$sc=explode('-',substr($exp[2],strpos($exp[2],':')+1));
		$this->set_g1($sc[0]);
		$this->set_g2($sc[1]);
	//get type 
		preg_match("#\((.*?)\)#",$exp[0],$matches);
		$this->set_type($matches[1]);
		$this->set_desc($var['desc']);
		$this->set_pubdate($var['pubdate']);
		}
	}
}
	
function get_rss_items($url) {
    // define url
    
    // retrieve search results
    if($xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA)) {
        $result["title"]   = $xml->xpath("/rss/channel/item/title");
        $result["link"]    = $xml->xpath("/rss/channel/item/link");
        $result["desc"] = $xml->xpath("/rss/channel/item/description");
        $result["pubdate"] = $xml->xpath("/rss/channel/item/pubDate");

        foreach($result as $key => $attribute) {
            $i=0;
            foreach($attribute as $element) {
                $ret[$i][$key] = (string)$element;
                $i++;
            }
        }    
        return $ret;    
    } else
        return false;    
}
    
?>
