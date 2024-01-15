<?php

/*
File name: rps.php
Author: Min Liu
Date created: August 1, 2023
Date modified: August 12, 2023
Version: 4.0

Purpose: learn programming server-side functionality using PHP to provide
         access to a database to register and login users
Description: This page implements "Rock-Paper-Scissors-Lizard-Spock" game. 
Users can make a choice from the available options (rock, paper, scissors, lizard, spock), 
compete against a random machine choice, and view the results. The game keeps track of the 
user's and machine's scores as they play multiple rounds.
*/


/*
    Rock-Paper-Scissors-Lizard-Spock Game
*/

// Initialize game variables
$choices = ["paper", "scissors", "rock", "lizard", "spock"];
$icon = [ // add icon for every choice
  "paper" => "paper &#9995;",
  "scissors" => "scissors &#9996;",
  "rock" => "rock &#9994;",
  "lizard" => "lizard &#129422;",
  "spock" => "spock &#128406;"
];

$winner = [
  "rock" => ["paper", "spock"],
  "paper" => ["scissors", "lizard"],
  "scissors" => ["spock", "rock"],
  "lizard" => ["rock", "scissors"],
  "spock" => ["lizard", "paper"]
];

// Function to get a random choice
function getRandomChoice()
{
  global $choices;
  return $choices[array_rand($choices)];
}

// Function to determine the winner
function determineWinner($machineChoice, $humanChoice)
{
  global $winner;
  if ($machineChoice == $humanChoice) {
    return "IT'S A TIE!";
  } elseif (in_array($humanChoice, $winner[$machineChoice])) {
    return "YOU WIN!";
  } else {
    return "MACHINE WINS!";
  }
}

// Initialize scores if not set
if (!isset($_SESSION['machineScore'])) {
  $_SESSION['machineScore'] = 0;
}
if (!isset($_SESSION['humanScore'])) {
  $_SESSION['humanScore'] = 0;
}

// Handle user choice and update scores
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["choice"])) {
  $machineChoice = getRandomChoice();
  $humanChoice = $_POST["choice"];
  $result = determineWinner($machineChoice, $humanChoice);
  // Update scores
  if ($result == "YOU WIN!") {
    $_SESSION['humanScore']++;
  } elseif ($result == "MACHINE WINS!") {
    $_SESSION['machineScore']++;
  }
}
?>


<main>
  <form method="POST">
    <label><strong>Your Move </strong></label>
    <select name="choice" id="choice">
      <option value="rock">Rock</option>
      <option value="paper">Paper</option>
      <option value="scissors">Scissors</option>
      <option value="lizard">Lizard</option>
      <option value="spock">Spock</option>
    </select>
    <button type="submit">Select and Play</button>
  </form>

  <!-- Display user and machine choices -->
  <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["choice"])) : ?>
    <div>
      <ul class="f-switch">
        <li class="box"><b>Human chose:</b> <?= $icon[$humanChoice]; ?></li>
        <li class="box"><b>Machine chose:</b> <?= $icon[$machineChoice]; ?></li>
      </ul>

    </div>

    <!-- Display user and machine scores -->
    <p><strong>Result: </strong><?php echo $result; ?></p>

    <div>
      <ul class="f-switch">
        <li class="box">Human Score: <?php echo $_SESSION['humanScore']; ?></li>
        <li class="box">Machine Score: <?php echo $_SESSION['machineScore']; ?></li>
      </ul>

    </div>

  <?php endif; ?>
</main>