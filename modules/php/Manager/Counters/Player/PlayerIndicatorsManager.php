<?php
namespace Bga\Games\tycoonindianew\Manager\Counters\Player;

use Bga\Games\tycoonindianew\Game;

use Bga\Games\tycoonindianew\Type\Counters\InitialValues;
use Bga\Games\tycoonindianew\Type\Counters\MaxValues;
use Bga\Games\tycoonindianew\Type\Counters\MinValues;

use Bga\Games\tycoonindianew\Type\Counters\Player\PlayerIndicators;

class PlayerIndicatorsManager extends PlayerCounterManager {

  public function setupNewGame(array $players){
    $this->initDb($players);
  }

  protected function initDb(array $players): void {
    $counterNames = [];
    foreach (PlayerIndicators::cases() as $playerIndicator) {
      $counterNames[] = $playerIndicator->value;
    }

    $this->initDbPlayerCounters($players, $counterNames);
  }

  protected function initialValue(int $playerNo, string $counterName): int {
    $value = 0;

    if ($counterName == PlayerIndicators::PLAYER_INFLUENCE) {
      $value = $this->initialInfluence($playerNo);
    }
    elseif ($counterName == PlayerIndicators::PLAYER_MONEY) {
      $value = $this->initialMoney($playerNo);
    }
    elseif ($counterName == PlayerIndicators::PLAYER_PROMOTERS_IN_HAND) {
      $value = $this->initialPromotersInHand($playerNo);
    }
    elseif ($counterName == PlayerIndicators::PLAYER_LOAN_INTAKE_LEVEL) {
      $value = InitialValues::LOAN_INTAKE_LEVEL;
    }

    return $value;
  }

  /**
   * Minimum value given counter can have
   * @param string $counterName
   * @return int
   */
  protected function minValue(string $counterName): int {
    $min = MinValues::DEFAULT;
    if ($counterName == PlayerIndicators::PLAYER_LOAN_INTAKE_LEVEL->value) {
      $min = MinValues::LOAN_INTAKE_LEVEL;
    }

    return $min;
  }

   /**
   * Maximum value given counter can have
   * @param string $counterName
   * @return int|null
   */
  protected function maxValue(string $counterName): ?int {
    $max = null;
    if ($counterName == PlayerIndicators::PLAYER_LOAN_INTAKE_LEVEL->value) {
      $max = MaxValues::LOAN_INTAKE_LEVEL;
    }
    elseif (str_contains("rank", $counterName)) {
      $max = MaxValues::RANK;
    }
    elseif ($counterName == PlayerIndicators::PLAYER_PROMISSARY_NOTES) {
      $max = MaxValues::PROMISSARY_NOTES;
    }

    return $max;
  }

  /**
   * Obtain initial influence for player
   * @param int $playerNo
   * @return int
   */
  private function initialInfluence(int $playerNo): int {
    return Game::get()->getPlayersNumber() + 1 - $playerNo;
  }

  /**
   * Obtain initial money for player
   * @param int $playerNo
   * @return int
   */
  private function initialMoney(int $playerNo): int {
    return $playerNo == 1 ? InitialValues::MONEY_TYCOON : InitialValues::MONEY;
  }

  /**
   * Obtain initial promoters in hand for player
   * @param int $playerNo
   * @return int
   */
  private function initialPromotersInHand(int $playerNo): int {
    return 7 - $this->initialInfluence($playerNo);
  }
}