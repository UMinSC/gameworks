<?php

/*
File name: cc.php
Author: Min Liu
Date created: August 1, 2023
Date modified: August 12, 2023
Version: 3.0

Purpose: learn programming server-side functionality using PHP to provide
         access to a database to register and login users
Description: This page implements the classic Casino Craps dice game. 
Players can roll two dice and observe the outcome, which can result in 
various win or loss scenarios. 
Players can track their wins and losses as they play multiple rounds of the game.

*/


/*
    Casino Craps Game
*/

// Initialize game variables
$displayGame = ""; // Variable to store game process messges
$displayScore = ""; // Variable to display game scores
$wins = isset($_SESSION['wins']) ? $_SESSION['wins'] : 0;
$losses = isset($_SESSION['losses']) ? $_SESSION['losses'] : 0;
$game = new CasinoCraps();


// Set up event methods
if (isset($_POST['play'])) {
  global $game;
  if (!isset($_SESSION['reroll'])) { // if not reroll, then start a new game
    $game = new CasinoCraps();
  }
  $game->rollBoth();
}


/* 
Class name: 	Member
*/
class CasinoCraps
{
  private $point = 0;

  // Roll two dice and calculate the outcome
  public function rollBoth()
  {
    $alpha = $this->roll();
    $bravo = $this->roll();
    $total = $alpha + $bravo;
    // Add content to the displayGame variable
    $this->addToDisplay($alpha . " + " . $bravo . " = " . $total . "      ");
    $this->determineOutcome($total);
  }

  // Determine the outcome based on the total
  private function determineOutcome($total)
  {
    switch ($this->point) {
      case 0:
        switch ($total) {
          case 7:
          case 11:
            $this->display("natural");
            break;
          case 2:
          case 3:
          case 12:
            $this->display("craps");
            break;
          default:
            $this->point = $total;
            $this->reroll(); // Prompt for reroll
            break;
        }
        break;
      default:
        switch ($total) {
          case $this->point:
            $this->display("point");
            $this->point = 0;
            break;
          case 7:
            $this->display("seven");
            $this->point = 0;
            break;
          default:
            $this->reroll(); // Prompt for reroll
            break;
        }
        break;
    }
  }

  // Prompt for reroll
  private function reroll()
  {
    // Add content to the displayGame variable
    $this->addToDisplay("<br> Your point is " . $this->point . " ...Roll again!");
    // Set the reroll flag
    $_SESSION['reroll'] = true;
  }

  // Display game outcome message
  private function display($msg)
  {
    global $wins, $losses;
    if ($msg == "natural" || $msg == "point") {
      $message = "That's a $msg. <br>✨ <b>You win!</b> ✨";
      $wins++;
      $_SESSION['wins'] = $wins;
    } else {
      $message = "That's a $msg. <br><b>You lose!</b>";
      $losses++;
      $_SESSION['losses'] = $losses;
    }
    // Add content to the displayGame variable
    $this->addToDisplay($message . "<br><br>New Game ?");
    // Clear the reroll flag
    unset($_SESSION['reroll']);
  }


  // Roll a single die
  private function roll()
  {
    return rand(1, 6);
  }

  // Add content to the displayGame variable
  private function addToDisplay($content)
  {
    global $displayGame;
    $displayGame .= $content;
  }
}


?>


<main>
  <form method="POST">
    <!-- Play button to roll the dice -->
    <input type="submit" name="play" value="Casino Craps Roll">
  </form>

  <!-- Display game scores -->
  <div id="score"><?= "<br>Wins: $wins, Losses: $losses<br> " ?></div>

  <!-- Display game process -->
  <?php if (!empty($displayGame)) : ?>
    <div class="info box" id="game"><?= $displayGame ?></div>
  <?php endif; ?>
</main>