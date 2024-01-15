<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $pagetitle = (isset($_GET['pagetitle'])) ? $_GET['pagetitle'] : "Home Page";
  ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title><?= $pagetitle ?></title>

  <!--
File name: header.php
Author: Min Liu
Date created: August 5, 2023
Date modified: August 5, 2023
Version: 1.0

Purpose: learn programming server-side functionality using PHP to provide
         access to a database to register and login users
Description: header part
    -->

  <link rel="stylesheet" href="css/missing.css">
  <link rel="stylesheet" href="css/w3Part.css">

</head>

<body>
  <!-- header of page -->
  <header>
    <h1>🎲 <span class="allcaps">GameWorks</span><v-h>:</v-h>
      <sub-title><?= $pagetitle ?></sub-title>
    </h1>