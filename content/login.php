<main>
  <form method="POST" action="">
    <!-- Include form fields for login -->
    <div class="w3-section">
      <label>Enter Username</label>
      <input class="w3-input w3-border w3-hover-border-grey" type="text" name="username" placeholder="Enter your username (required)">
    </div>
    <div class="w3-section">
      <label>Enter Password</label>
      <input class="w3-input w3-border w3-hover-border-grey" type="password" name="password" placeholder="Enter your password (required)">
    </div>

    <input class="w3-input w3-orange w3-margin-bottom w3-padding-16" type="submit" name="login" value="Login">
    <input class="w3-input w3-gray w3-padding-16" type="reset" name="reset" value="Reset">

  </form>

  <?php
  /*
File name: login.php
Author: Ellen Bajcar
Editor: Min Liu
Date created: Summer 2018
Date modified: August 12, 2023
Version: 23.4
Copyright: 
	This work is the intellectual property of Sheridan College. 
	Any further copying and distribution outside of class must be within 
	the copyright law. Posting to commercial sites for profit is prohibited.
Purpose: learn programming server-side functionality using PHP to provide
         access to a database to register and login users
Description:
	login form accessible to general public (everyone) and php code to connect and work with databases
*/

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['reset'])) {
      // Clear session variables related to form data
      unset($_SESSION['firstName']);
      unset($_SESSION['password']);

      // Redirect to the same page to reset the form fields
      header("Location: index.php?page=content/login.php");
      exit;
    }


    $_SESSION['formAttemp'] = true;
    $_SESSION['id'] = session_id();
    $_SESSION['isLoggedIn'] = false;

    if (isset($_POST['password']))
      if (!empty($_POST['password'])) {
        $_SESSION['password'] = $_POST['password'];
      } else
        echo "no password";

    //  can be used to record last time the user logged in successfully
    //$_SESSION['loginDate'] = $_POST['curdate'];

    if (isset($_POST['username']))
      if (!empty($_POST['username'])) {
        $safeuser = $_POST['username'];
        $_SESSION['firstName'] = $safeuser;
      } else
        echo "handle the bad name";

    require_once("includes/Member.php");
    $visitor = new Member;
    if ($visitor->authenticate($_POST['username'], $_POST['password'])) {
      // proceed to member site
      echo <<<_LOG_
<section>
<h3 class='w3-green w3-padding-16'>Authentication successful.</h3>
<a class='w3-button w3-gray'  
	href=index.php?page=content/home_members.php&members=true&pagetitle=Members-only%20Home%20Page>Proceed</a>
</section>
_LOG_;
    } else {
      // return to login
      session_destroy();
      echo <<<_NOLOG_
<section>
<h3 class='w3-center w3-block w3-red w3-padding-16'>Authentication was unsuccessful.</h3>
<a class='w3-button w3-gray' href='index.php?page=content/login.php'>Try Again</a>
</section>
_NOLOG_;
    }
  }
  ?>
</main>