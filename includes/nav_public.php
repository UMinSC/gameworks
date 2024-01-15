<?php
/*
File name: nav_public.php
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
	navigation component accessible to general public (everyone)
    $members variable is NOT set since user has not logged in (yet)
*/
?>
<nav>
  <p class="tool-bar">
    <a class="active" href="index.php?page=content/home_public.php">
      Home
    </a>
    <a href="index.php?page=content/login.php&pagetitle=Member%20Login">
      Login
    </a>
    <a href="index.php?page=content/register.php&pagetitle=Become%20A%20Member">
      Become a member
    </a>
  </p>
</nav>
</header>