<?php
/*
File name: nav_members.php
Author: Ellen Bajcar
Editor: Min Liu
Date created: Summer 2018
Date modified: August 12, 2023
Version: 23.0
Copyright: 
	This work is the intellectual property of Sheridan College. 
	Any further copying and distribution outside of class must be within 
	the copyright law. Posting to commercial sites for profit is prohibited.
Purpose: learn programming server-side functionality using PHP to provide
         access to a database to register and login users
Description:
	navigation component accessible to members who logs in
*/
?>
<nav>
  <p class="tool-bar">
    <a class="active" href="index.php?page=content/home_members.php&members=false">
      Home
    </a>
    <a href="index.php?page=content/cc.php&pagetitle=Casino craps&members=false" title="Casino craps">
      Casino craps
    </a>
    <a href="index.php?page=content/rps.php&pagetitle=Rock-Paper-Scissors-Lizard-Spock&members=false" title="Rock-Paper-Scissors-Lizard-Spock">
      RPSLS
    </a>
    <a href="index.php?page=content/ttt.php&pagetitle=Tic-Tac-Toe&members=false" title="Tic-Tac-Toe">
      Tic tac toe
    </a>
    <a href="index.php">
      Sign out
    </a>
  </p>
</nav>
</header>