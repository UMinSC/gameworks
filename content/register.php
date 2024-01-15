<main>
  <form method="POST" action="">
    <!-- Include form fields for registration -->
    <div class="w3-section">
      <label>Enter Username</label>
      <input class="w3-input w3-border w3-hover-border-grey" style="width:100%;" type="text" name="username" placeholder="Enter your username (required)">
    </div>
    <div class="w3-section">
      <label>Enter Password</label>
      <input class="w3-input w3-border w3-hover-border-grey" style="width:100%;" type="password" name="password" placeholder="Enter your password (required)">
    </div>
    <input class="w3-input w3-orange w3-margin-bottom w3-padding-16" type="submit" name="login" value="Register">

  </form>


  <?php

  /*
File name: register.php
Author: Ellen Bajcar
Editor: Min Liu
Date created: Summer 2018
Date modified: August 12, 2023
Version: 23.5
Copyright: 
	This work is the intellectual property of Sheridan College. 
	Any further copying and distribution outside of class must be within 
	the copyright law. Posting to commercial sites for profit is prohibited.
Purpose: learn programming server-side functionality using PHP to provide
         access to a database to register and login users
Description:
	register form accessible to general public (everyone) and php code to connect and work with databases
*/


  // Function to clean up a data string (from w3schools.com)
  function clean($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function initProcess()
  {
    $_SESSION['formAttemp'] = true;  // can be implemented to restrict number of attempts
    $_SESSION['id'] = session_id();
    $_SESSION['isLoggedIn'] = false;
    $_SESSION['firstName'] = $_POST["username"];
    $_SESSION['password'] = $_POST['password'];
  }

  function testUsername()
  {
    global $errMsg, $safeuser;
    if (isset($_POST['username']))
      if (!empty($_POST['username'])) {
        $safeuser = clean($_POST["username"]);
        $_SESSION['firstName'] = $safeuser;
      } else {
        $errMsg = "username field is empty. You must choose a username.";
        return false;
      }
    return true;
  }

  function testPassword()
  {
    global $password, $errMsg;
    if (isset($_POST["password"])) {
      $password = clean($_POST["password"]);
      // when database field length is set to 40; what would be the minimum?
      if (strlen($password) < 4 || strlen($password) > 40) {
        error_log("Password must be between 4 and 40 characters: $password\n", 3, "myErrors.log");
        $errMsg = "Password parameter must be between 4 and 40 characters" .
          " long. The length of $password is " . strlen($password);
        return false;
      }
    } else {
      $errMsg = "Second parameter missing.";
      error_log("$errMsg -missing.", 3, "myErrors.log");
      return false;
    }
    return true;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errMsg = '';
    global $safeuser, $password;
    initProcess();

    require_once("includes/Member.php");
    $visitor = new Member;
    if (testUsername() && testPassword()) {
      if ($visitor->registerMember($safeuser, $password)) {
        // Done: proceed to member site
        echo <<<_Regist_
<section>
<h3 class='w3-green w3-padding-16'>Regist successful.</h3>
<a class='w3-button w3-gray'  
	href=index.php?page=content/home_members.php&members=true&pagetitle=Members-only%20Home%20Page>Proceed</a>
</section>
_Regist_;
      } else {
        session_destroy();
        // return to registration
        echo <<<_UnRegist_
<section>
<h3 class='w3-center w3-block w3-red w3-padding-16'>Regist was unsuccessful.</h3>
<a class='w3-button w3-gray' href='index.php?page=content/register.php'>Try Again</a>
</section>
_UnRegist_;
      }
    } else {
      echo "returned false line 102.";
    }
  }
  ?>
</main>