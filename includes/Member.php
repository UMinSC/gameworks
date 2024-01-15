<?php
/* Class name: 	Member
 * Description: A class that creates a User for members-only web app.
 * Citation:	PHP, MySQL, Javascript & HTML5 for Dummies, S.Suehring, J.Valade
 * Member is a data-aware class; data source that connects to a database
 * 
 * |----------------------------------------
 * | $id
 * | $firstName
 * | $password
 * | $isLoggedIn
 * |----------------------------------------
 * | __construct
 * | registerMember($safeUser, $newPass)
 * | authenticate($user, $pass)
 * | _initUser()
 * | _setSession()
 * |----------------------------------------
 * //Done. add registerMember and authenticate methods
 * 
 */
class Member
{
	private $id;
	private $firstName;
	private $password;
	private $isLoggedIn = false;



	/* Constructor: 
	 * starts session and calls_initUser() method to initialize user info
	 */
	function __construct()
	{
		if (session_id() == "") {
			session_start();
		}
		$this->_initUser();
	}



	/* 
	 *	public function registerMember($safeUser)
	 */
	public function registerMember($safeUser, $newPass)
	{
		//connect to database
		require('info.php');
		try {
			$dbh = new PDO("mysql:host=localhost;dbname=$DATABASENAME", $USERNAME, $PASSWORD);
		} catch (Exception $e) {
			error_log("Cannot connect to MySQL: $e\n", 3, "myErrors.log");
			return false;
		}
		// if not using UNIQUE in database, ensure that the user does not exists already		
		// otherwise, insert new record
		$password = $newPass;
		$date = date("Y-m-d");
		//$address = $_SESSION['address'];
		$command = "INSERT INTO members ( player, password, startdate ) 
                VALUES ( '$safeUser','$password','$date')";
		if (!$result = $dbh->prepare($command)) {
			error_log("Query does not appear to be correct: $safeUser\n", 3, "myErrors.log");
			return false;
		}
		if (!$result->execute()) {
			error_log("User already exists. $safeUser\n", 3, "myErrors.log");
			return false;
		}
		$this->_setSession();
		$dbh = "";
		return true;
	}


	// public function authenticate($user, $pass)

	public function authenticate($user, $pass)
	{
		// connect to database
		require('info.php');
		try {
			$dbh = new PDO(
				"mysql:host=localhost;dbname=$DATABASENAME",
				$USERNAME,
				$PASSWORD
			);
		} catch (Exception $e) {
			error_log("Cannot connect to MySQL: $e\n", 3, "myErrors.log");
			return false;
		}

		// retrieve user's record
		$safeUser = $user;
		$inPassword = $pass;
		$query = "SELECT * FROM members WHERE player='$safeUser'";
		if (!$result = $dbh->prepare($query)) {
			error_log("Cannot retrieve account for: $safeUser\n", 3, "myErrors.log");
			return false;
		}

		// compare userid and password
		if ($result->execute()) {
			$row = $result->fetch();
			$dbPassword = $row['password'];
			if ($inPassword != $dbPassword) {
				error_log("Passwords do not match. $safeUser\n", 3, "myErrors.log");
				return false;
			}
		}

		$this->firstName = $row['player'];
		$this->password = $row['password'];
		$this->isLoggedIn = true;
		//update current session info
		$this->_setSession();
		// close connection
		$dbh = NULL;
		return true;
	}

	/* 
	 *  private function _initUser() called by the constructor
	 */
	private function _initUser()
	{
		if (session_id() == '') {
			session_start();
		}
		$this->id = $_SESSION['id'];
		$this->firstName = $_SESSION['firstName'];
		$this->password = $_SESSION['password'];
		$this->isLoggedIn = $_SESSION['isLoggedIn'];
	}

	/* 
	 *  public function _setSession() called from authenticate() function
	 */
	private function _setSession()
	{
		$_SESSION['id'] = $this->id;
		$_SESSION['firstName'] = $this->firstName;
		$_SESSION['password'] = $this->password;
		$_SESSION['isLoggedIn'] = $this->isLoggedIn;
	}
} // end class Member
