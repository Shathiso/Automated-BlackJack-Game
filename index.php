<?php

/**
   * Entelect Assesment : BlackJack Card Game.
   * Creator: Shathiso Ntibi
   */

class BlackJack
{
  /* Class variables */
  protected $Dealer;
  protected $Billy;
  protected $Lemmy;
  protected $Andrew;
  protected $Carla;
  protected $Players = [];
  protected $deck = [];
  public $types = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];
  public $values = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'Jack', 'Queen', 'King', 'Ace'];

  /* Class Contructor declaration */
  public function __construct()
  { 
    self::initialize_Players();
    self::create_deck();
    self::shuffle();
    self::deal();
  }

   /* This method creates the players as objects/multidimension arrays &
   stores them in a single object */
  public function initialize_Players() {
    $this->Dealer = ['Name' => 'Dealer', 'Points' => 0, 'Hand' => [], 'Wins' => 0, 'Loses' => 0];
    $this->Billy = ['Name' => 'Billy', 'Points' => 0, 'Hand' => [], 'Wins' => 0, 'Loses' => 0];
    $this->Lemmy = ['Name' => 'Lemmy', 'Points' => 0, 'Hand' => [], 'Wins' => 0, 'Loses' => 0];
    $this->Andrew = ['Name' => 'Andrew', 'Points' => 0, 'Hand' => [], 'Wins' => 0, 'Loses' => 0];
    $this->Carla = ['Name' => 'Carla', 'Points' => 0, 'Hand' => [],'Wins' => 0, 'Losses' => 0];

    array_push($this->Players, $this->Dealer, $this->Andrew, $this->Billy, $this->Carla, $this->Lemmy);
  }

  /* Creating the 52 cards in a Deck  */
  public function create_deck() {
    $val_len = count($this->values);
    $typ_len = count($this->types);
    $deck = array();

    for ($x = 0;$x < $val_len;$x++) {
      for ($y = 0;$y < $typ_len;$y++) {

        $amount = $this->values[$x];
        if ($this->values[$x] == 'Jack' || $this->values[$x] == 'King' || $this->values[$x] === 'Queen') {
          $amount = 10;
        }
        elseif ($this->values[$x] == 'Ace') {
          $amount = 1;
        }
        else{}

        $card = ['type' => $this->types[$y], 'value' => $this->values[$x], 'amount' => $amount];
        array_push($this->deck, $card);
      }
    }
  }

  /* This method Shuffles the Deck of cards into a random order  */
  public function shuffle() {
    $decklen = count($this->deck);
        // switch the values of two random cards
        for ($i = 0; $i < 52; $i++){
            $index1 = rand(0, $decklen - 1);
            $index2 = rand(0, $decklen - 1);
            $tmp = $this->deck[$index1];

            $this->deck[$index1] = $this->deck[$index2];
            $this->deck[$index2] = $tmp; 
        }
  }

  /* This method deals te cards to each player as long as their total points are not greater 21,
   * This method also checks the users points total and reassigns the value of the Ace card if --
   * -- the users points are less than 10 or greater than 10
   * This method then displays each players hand after all the cards are dealt */

  public function deal() {
    $countPlayers = count($this->Players);
    $dealtCard;

    for ($x = 0;$x < $countPlayers;$x++) {
      while($this->Players[$x]['Points'] < 20) {
        $dealtCard = array_pop($this->deck);
        if($dealtCard['amount'] == 1 && $this->Players[$x]['Points'] < 10){
          $dealtCard['amount'] = 11;
          array_push($this->Players[$x]['Hand'], $dealtCard);
          self::updatePoints();
        }
        else{
          array_push($this->Players[$x]['Hand'], $dealtCard);
          self::updatePoints();
        }
        self::updatePoints();
      }
    }

      self::displayWinner();
  }

  /* This method retrieves the Points from the Players hands, adds them up and assigns the total to each player*/
  public function getPoints($player) {
    $points = 0;
    for ($i = 0;$i < count($this->Players[$player]['Hand']);$i++) {
      $points += $this->Players[$player]['Hand'][$i]['amount'];
    }
    $this->Players[$player]['Points'] = $points;
  }

  /* This method simply iterates over the players and inputs the current players array index into the Get Points method */
  public function updatePoints() {
    $countPlayers = count($this->Players);
    for ($x = 0;$x < $countPlayers;$x++)
    {
      self::getPoints($x);
    }
  }

  /* This method assigns each card value to a string for a readable output */
  public function getCardValue($value){
    switch ($value) {
      case 2:
        return "Two";
      break;
      case 3:
        return "Three";
      break;
      case 4:
        return "Four";
      break;
      case 5:
        return "Five";
      break;
      case 6:
        return "Six";
      break;
      case 7:
        return "Seven";
      break;
      case 8:
        return "Eight";
      break;
      case 9:
        return "Nine";
      break;
      case 10:
        return "Ten";
      break;
      case 'Jack':
        return "Jack";
      break;
      case 'Queen':
        return "Queen";
      break;
      case 'King':
        return "King";
      break;
      case 'Ace':
        return "Ace";
      break;
    }
  }

  /* This method displays each players hand to the screen */
  public function displayWinner() {

    $count = count($this->Players);
    
    for($player = 0; $player < $count;$player++) {
      echo "\n{$this->Players[$player]['Name']} " . "\n";
      foreach ($this->Players[$player]['Hand'] as $cards) {
        echo self::getCardValue($cards['value']) . " of " . $cards['type'] . "\n";
         }
         if($this->Players[$player]['Name'] == 'Dealer'){
         echo "Total Points: " . $this->Players[0]['Points']. "\n";
         }

      /* The following if statement checks if the player is not a dealer--
      *  -- and hes hand is equal to or exceeds the dealers and is less than 21
      */
      if($this->Players[$player]['Name'] != 'Dealer' && count($this->Players[$player]['Points']) >= count($this->Players[0]['Points'])  && $this->Players[$player]['Points'] <= 21 ){
        echo $this->Players[$player]['Name']." - ".$this->Players[$player]['Points']. " - Wins". "\n";

      }
      else if($this->Players[$player]['Name'] != 'Dealer'){
        echo "{$this->Players[$player]['Name']} - " .$this->Players[$player]['Points']. " - Loses". "\n";

      }
      else{}
    }

  }
}

//Initializing the class as an object and starting the game
$newGame = new BlackJack();