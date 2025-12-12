<?php
namespace Bga\Games\tycoonindianew\Manager\Card;

use Bga\Games\tycoonindianew\Model\Card\PlanningCommission\PlanningCommissionCard;

use Bga\Games\tycoonindianew\Type\CardLocation;
use Bga\Games\tycoonindianew\Type\CardType;
use Bga\Games\tycoonindianew\Type\CardTypeArg;

class PlanningCommissionCardManager extends CardManager {

  /**
   * Handle setting up planning commissions as part of new game setup, for given players
   * This MUST only be called once during a game, i.e. during new game setup
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players) {
    $this->setupNewDeck();
  }

  /**
   * Setup new deck of planning commissions
   * This MUST only be called once during a game, i.e. during new game setup
   * @return void
   */
  protected function setupNewDeck() {
    // Setup Type A Planning Commissions
    $this->setupDeck(
      CardType::PLANNING_COMMISSION,
      CardTypeArg::PLANNING_COMMISSION_A,
      CardLocation::PLANNING_COMMISSION_A_DECK,
      PlanningCommissionCard::FILEPATH_A,
      PlanningCommissionCard::CLASSPATH_A
    );
    
    // Setup Type B Planning Commissions
    $this->setupDeck(
      CardType::PLANNING_COMMISSION,
      CardTypeArg::PLANNING_COMMISSION_B,
      CardLocation::PLANNING_COMMISSION_B_DECK,
      PlanningCommissionCard::FILEPATH_B,
      PlanningCommissionCard::CLASSPATH_B
    );
  }
}