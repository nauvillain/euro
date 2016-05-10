<?php

function display_threads($min){

	$active=find_active_threads($min);
	if(!mysql_num_rows($active)) return;
	while($row=mysql_fetch_array($active)){
		 display_main_thread($row['id'],$row['title'],0,$min);
	
	}
	return 1;

}

function load_post($t_id){
	echo "<>";
}

function find_active_threads($min){
	$sql=mysql_query("SELECT id,content,title FROM forum WHERE".($min?" DATE_SUB(NOW(),INTERVAL $min MINUTE)< last_mod AND":"")." thread='0' ORDER BY last_mod desc") or die(mysql_error());	
	return($sql);
}

function display_main_thread($t_id,$title,$root,$min){
	$m_sql=mysql_query("SELECT * FROM forum WHERE id='$t_id'") or die(mysql_error());
	if($m_sql) $num_threads=mysql_num_rows($m_sql);
	else $num_threads=0;
	//echo "<ul>\n";
	$par_id=mysql_result($m_sql,0,'thread');
	//count new items
	$new_items=count_new_items($t_id,$min,0);
//	if(!$par_id) $new_items--;
	//find out whether it's new
	$new=is_post_new($t_id,$min);
	//display date
	$post_date=mysql_result($m_sql,0,'last_mod');
	$str_post_date=format_date($post_date);
	if(!$par_id||$new||$new_items) $class_js="expanded";
	else $class_js="trigger";
	//format the font if the post is new
	if($new&&$par_id){
		$div_bold="<div class='forum_content_new'>\n";
		$div_bold_end="</div>";
	}
	else {
		$div_bold="<div class='forum_content dont-break-out'>";
		$div_bold_end="</div>";
	}
	//if it's a main thread, put a frame
	$username=mysql_result($m_sql,0,'user_name');
	$userid=mysql_result($m_sql,0,'user_id');
	if(!$par_id)echo "<div style='margin-bottom:15px;'>\n";	
	echo "<div id='t_$t_id' name='titles_$t_id' class='$class_js'>\n";
	echo ($root?"Re:":"<span class='forum_thread_title'>".$title."</span>");
	//" (".mysql_result($m_sql,0,'user_name').")";
	//($new_items?", $new_items new":"").
	echo " -- <div class='post_date'>".($par_id?"":get_word_by_id(107))." ".$str_post_date."</div>";
	echo "</div>\n";
	//echo "<li>\n";
	//display post content
	echo "<div  name='contents_$t_id' class='forum_content'>\n";
	echo $div_bold;
	echo "[<a href='player_profile.php?id=$userid'>$username</a>] \n";
	$conttt=mysql_result($m_sql,0,'content');
	$conttt=str_replace('+',"&#43;",$conttt);
	$conttt=str_replace('-',"&#45;",$conttt);
	$conttt=str_replace('"',"&#34;",$conttt);
	$conttt=str_replace('$',"&#36;",$conttt);
	$conttt=str_replace('*',"&#42;",$conttt);
	
	echo urldecode(nl2br($conttt));
	echo $div_bold_end;
	$id=mysql_result($m_sql,0,'id');
	//display actions linked to the post
	display_options($par_id,$id);
	$sql=mysql_query("SELECT * FROM forum WHERE thread='$t_id'") or die(mysql_error());
	$num_threads=mysql_num_rows($sql);
	if($num_threads) {
		for($i=0;$i<$num_threads;$i++) {	
			$id=mysql_result($sql,$i,'id');
			echo "<div>\n";
			 display_main_thread($id,$title,1,$min);
			echo "</div>\n";
		}
	}
	echo "</div>\n";
	if(!$par_id)echo "</div>\n";	

//	echo "</li>\n";
//	echo "</ul>\n";
}

function display_options($t_id,$id){
		
	echo "<div id='reply_thread' style='display:inline';>\n";
	$div_id=$t_id."_".$id;
	echo "<div id='".$div_id."' style='display:inline';>\n";
	echo "<a  class='ajax_link' onClick=\"javascript:addPost('".$div_id."')\" >".get_word_by_id(105);
	echo "</a>\n";
	echo "</div>\n";
	echo "</div>\n";
}
function update_thread_timestamp($id){

	if($id) {
		$t_id=mysql_result(mysql_query("SELECT thread FROM forum WHERE id='$id'"),0);
		if($t_id<>'0') {
			//mysql_query("UPDATE forum SET mo='1' WHERE id='$id'") or die(mysql_error());
			update_thread_timestamp($t_id);
			}
		else mysql_query("UPDATE forum SET mo=mo+1 WHERE id='$id'") or die(mysql_error());
	}
	else return;
}

function count_new_items($id,$min,$count){
	

	$sql=mysql_query("SELECT last_mod FROM forum WHERE id='$id'") or die(mysql_error());
	$count+=is_post_new($id,$min);
	//add the children if it's also a thread
	$sql=mysql_query("SELECT last_mod,id FROM forum WHERE thread='$id'") or die(mysql_error());
	$num=mysql_num_rows($sql);
	if($num){
		for($i=0;$i<$num;$i++){
			$new_id=mysql_result($sql,$i,'id');
			//$count+=is_post_new($new_id,$min);
			//if the thread is new too, or if it's the last post, count it
			return count_new_items($new_id,$min,$count);
		}
	}
	else return $count;
	
}
function format_date($d){
global $language;

	$phpdate=strtotime($d);
	$time=time()-$phpdate;
	if($time<3600) {
		$f=round($time/60);
		$unit=get_word_by_id(143);
		
	}

	if(($time<86400)&&($time>=3600)) {
		$f=round($time/3600);
		$unit=get_word_by_id(144);
	}
	if(($time<2592000)&&($time>=86400)) {
		$f=round($time/86400);
		$unit=get_word_by_id(145);	
	}
		switch($language){
			case 'en': if($unit!="day") $u=$f." ".$unit." ago";
				else $u="yesterday";
				if($f>1) $u=$f." ".$unit."s ago"; 
				break;
			case 'fr':
			$u="il y a ".$f." ".$unit;
			if($f>1) $u="il y a ".$f." ".$unit."s";
			break;
			case 'hu': $u=$f." ".$unit." ezelőtt";
			break;
		}	
	
	return $u;
}
function is_post_new($id,$min){
	$sql=mysql_query("SELECT last_mod FROM forum WHERE id='$id'") or die(mysql_error());
	$phpdate=strtotime(mysql_result($sql,0,'last_mod'));
	if((time()-$phpdate)<$min*60) return 1;
	else return;
	
}
function utf8_to_unicode_code($utf8_string){
	$expanded = iconv("UTF-8", "UTF-32", $utf8_string);
	return unpack("L*", $expanded);
}

function conv($str){
	return iconv("UTF8","ISO-8859-1",$str);
}
?>
