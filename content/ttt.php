<?php
/*
File name: ttt.php
Author: Min Liu
Date created: August 2, 2023
Date modified: August 12, 2023
Version: 5.0

Purpose: learn programming server-side functionality using PHP to provide
         access to a database to register and login users
Description: This page displays the Tic-Tac-Toe game interface where users 
can play the game. It consists of a 3x3 grid of cells, each represented by 
an 'X', 'O', or empty. Players can click on the cells to make their moves 
and a message displays the current player's turn or the winner of the game.
*/


/*
    Tic Tac Toe Game
*/

// Initialize the game
$winSets = [[0, 1, 2], [3, 4, 5], [6, 7, 8], [0, 3, 6], [1, 4, 7], [2, 5, 8], [0, 4, 8], [2, 4, 6]];
if (!isset($_SESSION['redCell'])) {
  $_SESSION['redCell'] = [];
}
if (!isset($_SESSION['board'])) {
  $_SESSION['board'] = ['T', 'I', 'C', 'T', 'A', 'C', 'T', 'O', 'E'];
  $_SESSION['player'] = "X";
  $_SESSION['empty'] = 9;
  $_SESSION['gameover'] = false;
}

/*
	Set up event methods
	1. when user clicks on the reset button (id="reset")
	2. when user clicks on the the 9 cells of the board
*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['reset'])) {
    gameReset();
  }
  if (isset($_POST['curCell'])) {
    $cellIndex = (int)$_POST['curCell'];
    cellClick($cellIndex);
  }
}

/*
    function gameReset() is called when user clicks on the "game reset" button
    1. sets content of all 9 cells to nothing
    2. sets the starting player (this version, X always starts the game)
    3. resets the number of empty cells to 9
    4. sets the game over flag to false to indicate that the game is in progress
    5. Resets the recorded winning cells
*/
function gameReset()
{
  for ($i = 0; $i < 9; $i++) {
    $_SESSION['board'][$i] = "";
  }
  $_SESSION['player'] = "X";
  $_SESSION['empty'] = 9;
  $_SESSION['gameover'] = false;
  $_SESSION['redCell'] = [];
}


/*
    Function cellClick() is called when the user clicks on one of the nine cells of the board
    1. sets the content of the clicked cell to the current player's mark
    2. checks whether or not there is a winner
    3. flips (changes) the current player
*/
function cellClick($cellIndex)
{
  // added conditional on game not being over and cells available
  if (!$_SESSION['gameover'] && $_SESSION['board'][$cellIndex] == "") {
    $_SESSION['board'][$cellIndex] = $_SESSION['player'];
    $_SESSION['empty']--;
    checkWin();
    if (!$_SESSION['gameover'])
      $_SESSION['player'] = ($_SESSION['player'] == "X") ? "O" : "X";
  }
}


/* 
    function checkWin() is called to check all winning combinations
*/
function checkWin()
{
  global $winSets;
  // if no empty cells, display game over
  // check if there are any remaining empty cells
  if ($_SESSION['empty'] == 0) {
    $_SESSION['gameover'] = true;
    $_SESSION['player'] = "No one ";
    return;
  }

  // check if any player wins the game
  foreach ($winSets as $winSet) {
    if (
      $_SESSION['board'][$winSet[0]] == $_SESSION['board'][$winSet[1]] &&
      $_SESSION['board'][$winSet[1]] == $_SESSION['board'][$winSet[2]] &&
      $_SESSION['board'][$winSet[0]] != ""
    ) {
      $_SESSION['gameover'] = true;
      // record the winning combo
      $_SESSION['redCell'] = $winSet;
      return;
    }
  }
}

/* 
    function displayMessage() is called to
    display the information of the game
*/
function displayMessage()
{

  if ($_SESSION['gameover']) {
    echo "Game Over! <b>" . $_SESSION['player'] . "</b> wins.";
  } else {
    echo "Player <b>" . $_SESSION['player'] . "</b> go!";
  }
}

/* 
    function displayCell($cellIndex) is called to
    display every td
*/
function displayCell($cellIndex)
{
  if ($_SESSION['board'][$cellIndex] == "") {
    echo "<td><input  type='submit' name='curCell' value='$cellIndex'>";
  } else {
    if ($_SESSION['gameover'] && in_array($cellIndex, $_SESSION['redCell'])) {
      echo "<td class='red'>" . $_SESSION['board'][$cellIndex];
    } else {
      echo "<td>" . $_SESSION['board'][$cellIndex];
    }
  }
}
?>

<!-- Include CSS stylesheet -->
<link rel="stylesheet" href="css/ttt.css">

<!-- Main game section -->
<main>
  <form class="ttt" method="POST">
    <table>
      <?php
      for ($row = 0; $row < 3; $row++) {
        echo "<tr>";
        for ($col = 0; $col < 3; $col++) {
          $cellIndex = $row * 3 + $col;
          displayCell($cellIndex);
          echo "</td>";
        }
        echo "</tr>";
      }
      ?>
    </table>
    <p>
      <button type="submit" name="reset">Reset Game</button> <?php displayMessage(); ?>
    </p>
  </form>
</main>