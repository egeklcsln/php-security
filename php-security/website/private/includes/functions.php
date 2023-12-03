<?php 

class Database{

	//connect to database
	private function connect()
	{
		try{

			$string ="mysql:host=localhost;dbname=security_db";
			$con=new PDO($string,"root","");

		}
		catch(PDOException $e){
			if($_SERVER['HTTP_HOST']=="localhost"){
				die($e->getMessage());
			}
			else{
				die("could not connect to the database");
			}

		}
		if(!$con = mysqli_connect("localhost","root","","security_db"))
		{
			die("could not connect to the database");
		}

		return $con;	
	}

	public function db_read($query,$data=array())
	{
		$con = $this->connect();
		$stm = $con->prepare($query);
	
		if ($stm) {
			$check = $stm->execute($data);
	
			if ($check) {
				$result = $stm->get_result();  
	
				if ($result) {
					$rows = $result->fetch_all(MYSQLI_ASSOC);
					if (is_array($rows) && count($rows) > 0) {
						return $rows;
					}
				}
			}
		}
	
		return false;
	}

	public function db_write($query,$data=array())
	{
		$con = $this->connect();
		$stm=$con->prepare($query);
		if($stm){
			$check =$stm->execute($data);
			if($check) {
				
					return $result;
				
			}
		}
		

		return false;

	}

	

}


class Post extends Database
{

	public function get_home_posts()
	{
		//get posts
		$query = "select * from posts order by id desc limit 2";
		return $this->db_read($query);
	}
	
	public function get_all_posts()
	{
		//get posts
		$query = "select * from posts order by id desc";
		return $this->db_read($query);
	}

	public function get_one_post($id)
	{
		//get the post
		$arr = array();
		$arr['id'] = (int)$id;
		$query = "select * from posts where id = :id limit 1";
		return $this->db_read($query,$arr);
	}

	
}

class User extends Database
{

	function login($POST)
	{
		$Error = "";
		 
		//validate
		//email
		if(!filter_var($POST['email'],FILTER_VALIDATE_EMAIL))
		{
			$Error = "wrong email or password";
		}

		//password
		if(empty($POST['password']))
		{
			$Error = "wrong email or password";
		}

		
		if($Error == "")
		{	$arr =array();
			$arr['email']	= addslashes($POST['email']);
			$arr['password']= addslashes($POST['password']);
	 
			//get user
			$query = "select * from users where email = :email && password = :password ";
			$result = $this->db_read($query,$arr);
	 
	 		if($result)
			{
				$row = $result[0];
	 				
	 			$_SESSION['user_id'] = $row['id'];
	 			$_SESSION['user_rank'] = $row['rank'];

	 			return "";
	 		}else{
	 			$Error = "wrong email or password";
	 		}

		}

		return $Error;
	}

	public function get_profile($id)
	{
		//get profile
		$arr = array();
		$arr['id'] = (int)$id;
		$query = "select * from users where id = :id limit 1";
		return $this->db_read($query,$arr);
	}
}


function access($needed_rank)
{
	$user_rank = isset($_SESSION['user_rank']) ? $_SESSION['user_rank'] : "";

	switch ($needed_rank) {
		case 'admin':
			// code...
			$allowed[] = "admin";

			return in_array($user_rank, $allowed);
			break;
		
		case 'editor':
			// code...
			$allowed[] = "admin";
			$allowed[] = "editor";

			return in_array($user_rank, $allowed);
			break;
		
		case 'user':
			// code...
			$allowed[] = "admin";
			$allowed[] = "editor";
			$allowed[] = "user";

			return in_array($user_rank, $allowed);
			break;
		
		default:
			// code...
			break;
	}

	return false;
}
