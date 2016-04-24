<?php
class user {
	public  $id;
	public  $username;
	private  $password;
	public  $first_name;
	public  $last_name;
	public  $nickname;
	public  $city;
	public  $country;
	public  $fav_team;
	public  $fav_player;
	public  $comments;
	public  $last_login;
	public  $profile_edited;
	public  $top_scorer;
	public  $player;
	public  $winner;
	public  $current_points;
	public  $current_correct;
	public  $current_incorrect;
	public  $bet_money;
	public  $email;
	public  $current_ranking;
	public  $language;
	public  $admin;
	public  $contact;
	public  $last_log;

	private $data;
	
	public function getUserData($id = 0){
	global $DB;
	//gets user data from a specific ID; if none is given, return the whole users table
		
		$query="SELECT * FROM users WHERE player=1";
		if(!$id){	
			return($DB->qry($query.";"));
		}
		else {
			$str2=" AND id='$id'";
			return($DB->qry($query.$str2.";",2));
		}
	}
	
	public function getUserRankings($sort='current_ranking',$desc='DESC'){
	global $DB;
	
		$order_by=" ORDER BY ".$sort." ".$desc;	
		$query="SELECT current_ranking,id,nickname,current_points FROM users WHERE player=1".$order_by;

		return($DB->qry($query));
			
		
			
	}
	

	public function displayUserRankings($object){
	//displaying a table of rankings from a getUserRankings mysql resource
		$hide=array('id');
		for($i=0;$i<2;$i++){
			$query=$object[$i];
			echo table::tableDisplay($query,$hide,2-2*$i);
		}	
	}


	public static function getUserRankingList(){
	//returns an array consisting of 2 mysql resources - 1st resource is position 1,2,3 and second resource is whichever positions are next to the user's current ranking
	//e.g. out of 60 players, if user ranking is 40, returns 1,2,3,38,39,40,41,42 ; if ranking is 60, returns 1,2,3,56,57,58,59,60
		global $login_id;
		global $DB;

		$array=array();
		$current_ranking=get_ranking($login_id);
		//test:		$current_ranking=4;
		$max=user::count_users();
		$scope = 2; //display + or - users around 

		$start_array=array();
		//initialize the start_array
		for($i=0;$i<3;$i++) array_push($start_array,$i+1);
		
		$offset=0;
		for($i=0;$i<$scope;$i++){
		//upper limit
			if($current_ranking==$i+1) $offset=$scope-$i;
		//lower limit
			if($current_ranking==$max-$i) $offset=$scope-4+$i;
		
		}
		for($i=-$scope;$i<$scope+1;$i++) array_push($array,$current_ranking+$offset+$i);
		
		//make sure $array does not contain positions 1,2 or 3
		$array=array_diff($array,$start_array);

		//format arrays for mysql queries
		$start_array=join(',',$start_array);
		$query1="SELECT current_ranking,id,nickname,current_points FROM users WHERE player=1 AND current_ranking IN (".$start_array.") ORDER BY current_ranking ASC LIMIT 5;";
		$array=join(',',$array);
		$query2="SELECT current_ranking,id,nickname,current_points FROM users WHERE player=1 AND current_ranking IN (".$array.") ORDER BY current_ranking ASC;";
		$result=array($DB::qry($query1),$DB::qry($query2));
		return($result);
		
	}	

	public static function count_users(){
	global $DB;
		
	return($DB->qry("SELECT count(*) FROM users WHERE player=1;",3));


	}
	
}

?>
