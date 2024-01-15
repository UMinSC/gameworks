<?php
/*
File name: home_members.php
Author: Ellen Bajcar
Editor: Min Liu
Date created: Summer 2018
Date modified: August 12, 2023
Version: 23.1
Copyright: 
	This work is the intellectual property of Sheridan College. 
	Any further copying and distribution outside of class must be within 
	the copyright law. Posting to commercial sites for profit is prohibited.
Purpose: learn programming server-side functionality using PHP to provide
         access to a database to register and login users
Description:
	main part accessible to members who logs in. a brief introduction.
*/
?>
<main>
  <h3>Welcome, <?= $_SESSION['firstName'] ?> !</h3>
  <p>Now that you have been our member, you can play the following games.</p>
  <ul>
    <li>Casino Craps</li>
    <li>Rock-Paper-Scissors-Lizard-Spock</li>
    <li>Tic Tac Toe</li>
  </ul>
</main>