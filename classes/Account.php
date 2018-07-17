<?php
	class Account {

		private $conn;
		private $errorArray;

		public function __construct($conn) {
			$this->conn = $conn;
			$this->errorArray = array();
		}

		public function login($username, $password) {

			$password = md5($password);

			$query = mysqli_query($this->conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");

			if(mysqli_num_rows($query) == 1) {
				return true;
			}
			else {
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}

		}

		public function register($username, $firstname, $lastname, $email, $password, $password2) {
			$this->validateUsername($username);
			$this->validateFirstName($firstname);
			$this->validateLastName($lastname);
			$this->validateEmail($email);
			$this->validatePasswords($password, $password2);

			if(empty($this->errorArray) == true) {
				//Insert into db
				return $this->insertUserDetails($username, $firstname, $lastname, $email, $password);
			}
			else {
				return false;
			}

		}

		public function getError($error) {
			if(!in_array($error, $this->errorArray)) {
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}

		private function insertUserDetails($username, $firstname, $lastname, $email, $password) {
			$encryptedPw = md5($password);
			$profilePic = "assets/images/profile-pics/head_emerald.png";
			$date = date("Y-m-d");

			$result = mysqli_query($this->conn, "INSERT INTO users VALUES ('', '$username', '$firstname', '$lastname', '$email', '$encryptedPw', '$date', '$profilePic')");

			return $result;
		}

		private function validateUsername($username) {

			if(strlen($username) > 25 || strlen($username) < 5) {
				array_push($this->errorArray, Constants::$usernameCharacters);
				return;
			}

			$checkUsernameQuery = mysqli_query($this->conn, "SELECT username FROM users WHERE username='$username'");
			if(mysqli_num_rows($checkUsernameQuery) != 0) {
				array_push($this->errorArray, Constants::$usernameTaken);
				return;
			}

		}

		private function validateFirstName($firstname) {
			if(strlen($firstname) > 25 || strlen($firstname) < 2) {
				array_push($this->errorArray, Constants::$firstNameCharacters);
				return;
			}
		}

		private function validateLastName($lastname) {
			if(strlen($lastname) > 25 || strlen($lastname) < 2) {
				array_push($this->errorArray, Constants::$lastNameCharacters);
				return;
			}
		}

        public function validateEmail($emailail)
        {
            if(!filter_var($emailail, FILTER_VALIDATE_EMAIL))
            {
                array_push($this->email, Constants::$emailailInvalid);
                return;
            }

            $checkEmailQuery = mysqli_query($this->conn, "SELECT email FROM users WHERE email = '$emailail'");
            if(mysqli_num_rows($checkEmailQuery) != 0)
            {
                array_push($this->errorArray, Constants::$emailailPresent);
            }
        }

		private function validatePasswords($password, $password2) {

			if($password != $password2) {
				array_push($this->errorArray, Constants::$passwordsDoNoMatch);
				return;
			}

			if(!preg_match('/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/', $password)) {
				array_push($this->errorArray, Constants::$passwordNotSymbolic);
				return;
			}

			if(strlen($password) > 30 || strlen($password) < 5) {
				array_push($this->errorArray, Constants::$passwordCharacters);
				return;
			}

		}


	}
?>
