<?php
	global $fr_m,$sr_m,$sr_l,$inf,$matches_showed,$arr_pick,$pts_victory;
	global $pts_draw,$trans_round,$groups,$resp_group_matches,$PTS_W,$TOT_WEIGHTS;
	global $third_place_match;
	global $web_path;
	
	$web_path="/";	

	$tournament_name="France 2016";
	$tournament_type="big_euro"; //values are 'euro', 'worldcup' or 'big_euro'

	$fr_m=36;
	 $sr_m=15;
	 $sr_l=4;// rounds in the second phase - ex quarter finals: 3
	 $inf="<img src='inf_small.jpg' alt=''/>";
	 $matches_showed=4;
	 $arr_pick[1]=1;
	 $arr_pick[2]="X";
	 $arr_pick[3]=2;
	 $pts_victory=3;
	 $pts_draw=1;
	 $trans_round=pow(2,$sr_l-1);
	 //$groups=array("A","B","C","D","E","F","G","H"); //world cup
	 $groups=array("A","B","C","D","E","F"); //big_euro
//	 $groups=array("A","B","C","D"); //euro
	 $resp_group_matches=3;
	 $PTS_W=10;
	 $TOT_WEIGHTS=192;
//	 $third_place_match=63;
	 $admin_id=1;
	 $language_array=array("en","hu","fr");
	 $language_meta=array("English","Hungarian","French");
	 $language_locale=array('en'=>"en_US.utf8",'hu'=>"hu_HU.utf8",'fr'=>"fr_FR.utf8");
	$cookie_life=40*86400;
	$session_n="france2016";
	$uploaddir="photos";
	$tmp_uploaddir="tmp_photos";
	$pot_admin=8; //Ranis is the pot race manager
	$site_admin=1;//I am the site admin
	$max_points_per_match=5;
	$bonus_scorer=5;
	$bonus_final_winner=10;
	$last_match=64;	

	$user_name_displays=array("username","first_name","nickname");
	$column_meta=array("current_points"=>'Pts.',"current_ranking"=>"#");

	$server_time_zone=-5;
	$tournament_time_zone=0;

	$tournament_has_started=array("en"=>"Here we go!","fr"=>"C'est parti!","hu"=>"Gyerünk!");

	$graph_color=array('yellow','red','gray','green','navy','orange','purple','red','cyan','darkgray');
	$plot_mark=array('yellow','navy','red','purple','cyan','gray');

	$coef_round=array('0'=>'1','8'=>1.5,'4'=>'2','2'=>'3','1'=>'4');

	$big_euro_3rd_place=array(
		"ABCD"=>array("C","D","A","B"),
		"ABCE"=>array("C","A","B","E"),
		"ABCF"=>array("C","A","B","F"),
		"ABDE"=>array("D","A","B","E"),
		"ABDF"=>array("D","A","B","F"),
		"ABEF"=>array("E","A","B","F"),
		"ACDE"=>array("C","D","A","E"),
		"ACDF"=>array("C","D","A","F"),
		"ACEF"=>array("C","A","F","E"),
		"ADEF"=>array("D","A","F","E"),
		"BCDE"=>array("C","D","B","E"),
		"BCDF"=>array("C","D","B","F"),
		"BCEF"=>array("E","C","B","F"),
		"BDEF"=>array("E","D","B","F"),
		"CDEF"=>array("C","D","F","E"));

?>
