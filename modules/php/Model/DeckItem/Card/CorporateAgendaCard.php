<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Card;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Multiplier\DynamicMultiplier;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Represents corporate agenda cards that return endgame favor to owners based on conditions
 * @property Effect $endgameFavor Endgame favor configuration for this corporate agenda card
 */
abstract class CorporateAgendaCard extends Card {

  public function __construct($args) {
    parent::__construct($args);

    $effectArgs = [
      "fieldName" => CorporateAgendaCard::FIELD_ENDGAME_FAVOR,
      "type" => EffectType::GAIN,
      "fungibleType" => FT::FAVOR,
      "amount" => 1,
      "multiplier" => new DynamicMultiplier([$this, "obtainEndgameFavorMultiplier"]),
      "condition" => null,
      "spec" => null,
      "next" => null,
      "trigger" => null,
      "roundDown" => false
    ];

    $this->assignEffect($effectArgs);
  }

  /**
   * Corporate agendas do not have any static fields
   * @return array
   */
  public static function staticFieldsList(): array {
    return [...[self::FIELD_ENDGAME_FAVOR], ...parent::staticFieldsList()];
  }

  /**
   * Static field args common to all corporate agenda cards, if any
   * @return array
   */
  public static function staticFieldArgs(): array {
    return [...parent::staticFieldArgs(), ...[]];
  }

  /** 
   * Corporate agendas can be gained
   * @return bool
   */
  public function canBeGained(): bool {
    return true;
  }

  /**
   * Corporate agendas cannot be lost once gained
   * @return bool
   */
  public function canBeLost(): bool {
    return false;
  }

  /**
   * Obtain the endgame favor multiplier for given player for the specific corporate agenda card calling this function (from its effect's multiplier)
   * @param int $playerId
   * @return float
   */
  abstract public function obtainEndgameFavorMultiplier(int $playerId): float;

  /** Constants - Field names */
  const FIELD_ENDGAME_FAVOR = "endgameFavor";

  /** Constants - Cards metadata */
  const FILEPATH = "/../../../CorporateAgenda/list.inc.php";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\CorporateAgenda";
}