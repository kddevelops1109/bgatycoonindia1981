<?php
namespace Bga\Games\tycoonindianew\Strategy\Scoring\Endgame;

use Bga\Games\tycoonindianew\Type\Ranking;
use InvalidArgumentException;

abstract class RankedEndgameScoringStrategy extends EndgameScoringStrategy {

  /**
   * Ranking to be used for this ranked endgame scoring strategy
   * @var Ranking
   */
  protected Ranking $ranking;

  /**
   * Constructor for ranked endgame scoring strategy
   * @param array $params
   * @throws InvalidArgumentException
   */
  protected function __construct(array $params) {
    if (!array_key_exists("ranking", $params)) {
      throw new InvalidArgumentException("Params must contain ranking for all ranked endgame scoring strategies");
    }

    $this->ranking = $params["ranking"];

    parent::__construct($params);
  }
}