<?php
namespace Bga\Games\tycoonindianew\Strategy\Scoring\Endgame;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Type\OperatorType;
use InvalidArgumentException;

class TieredEndgameScoringStrategy extends EndgameScoringStrategy {

  /**
   * Apply tiered scoring strategy
   * @param int $playerId
   * @param string|array $counterNames
   * @param array<string|int, int> $reference
   * @throws InvalidArgumentException
   * @return void
   */
  public function evaluate(int $playerId, string|array $counterNames, array $reference): int {
    $value = 0;

    // Tiered endgame scoring should really be using a single counter, so if the counter names is an array, throw an invalid argument exception
    if (is_array($counterNames)) {
      throw new InvalidArgumentException("Tiered scoring requires only one counter");
    }

    $tierOperator = $this->params["operator"];

    $actualValue = IndustrialistManager::getPlayerCounterValue($playerId, $counterNames);
    foreach ($reference as $expectedValue => $score) {
      $condition = false;
      if ($tierOperator == OperatorType::GREATER_THAN) {
        $condition = $actualValue > $expectedValue;
      }
      elseif ($tierOperator == OperatorType::GREATER_THAN_EQUALS) {
        $condition = $actualValue >= $expectedValue;
      }
      elseif ($tierOperator == OperatorType::LESSER_THAN) {
        $condition = $actualValue < $expectedValue;
      }
      elseif ($tierOperator == OperatorType::LESSER_THAN_EQUALS) {
        $condition = $actualValue <= $expectedValue;
      }
      elseif ($tierOperator == OperatorType::EQUALS) {
        $condition = $actualValue === $expectedValue;
      }

      if ($condition) {
        $value = $score;
        if ($tierOperator == OperatorType::EQUALS) {
          break;
        }
      }
    }

    return $value;
  }
}