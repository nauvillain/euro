<?php

class team {

	var $team_id; //team id
	var $team_name; //team name
	var $group_name; // group the team belongs to (A,B,C...)
	var $code; //short code - France = FRA...
	var $winner;//1 if winner, otherwise 0
	var $current_pos;//position in the group
	var $matches_played;//matches played
	var $won,$lost,$draw;// amount of matches won, lost, or tied
	var $gf,$ga;//goals for, goals against
	var $pts;// points in the group
	var $players_list;// whether the list of players has been entered - if so, set to 1
	var $trans; // ?

	protected var $connection;
	
	public function __set($name,$value){
		$this->$name=$value;
	}	
	
	public function __get($name){
		return($this->$name);
	}

}
//$var = new team();
//echo "good";
?>
