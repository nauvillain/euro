<?php
class DBController {

	private $host = "localhost";

	private $user = "root";

	private $password = "husi!chou";

	private $database = "russia18";

	public $conn;
	

	public function __construct() {

		$conn = $this->connectDB();


	}

	

	public function connectDB() {

		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);

		return $conn;

	}

	


	

	public function runQuery($query) {
		global $conn;
		$result = mysqli_query($conn,$query);

		while($row=mysqli_fetch_assoc($result)) {

			$resultset[] = $row;

		}		

		if(!empty($resultset))

			return $resultset;

	}

	

	public function numRows($query) {
		global $conn;
		$result  = mysqli_query($conn,$query);

		$rowcount = mysqli_num_rows($result);

		return $rowcount;	

	}

	

	public function updateQuery($query) {
		global $conn;
		$result = mysqli_query($conn,$query);

		if (!$result) {

			die('Invalid query: ' . mysqli_error($conn));

		} else {

			return $result;

		}

	}

	

	public function insertQuery($query) {
		global $conn;
		
		$result = mysqli_query($conn,$query);

		if (!$result) {

			die('Invalid query: ' . mysqli_error($conn));

		} else {

			return $result;

		}

	}

	

	public function deleteQuery($query) {
		$result = mysqli_query($conn,$query);

		if (!$result) {

			die('Invalid query: ' . mysqli_error($conn));

		} else {

			return $result;

		}

	}

}

?>
