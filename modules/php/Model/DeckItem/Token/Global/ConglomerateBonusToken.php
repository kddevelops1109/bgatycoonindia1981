<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Token\Global;

use Bga\Games\tycoonindianew\Effect\Effect;

/**
 * Conglomerate bonus tokens are bonuses users can claim when their production is at least 1 for all industrial sectors
 * @property Effect $bonus
 */
abstract class ConglomerateBonusToken extends GlobalToken {

  /**
   * Static fields list for conglomerate bonuses
   * @return array<string>
   */
  public static function staticFieldsList(): array {
    return [
      ...parent::staticFieldsList(),
      ...[self::FIELD_BONUS]
    ];
  }

  /**
   * Static field args for conglomerate bonuses
   * @return array
   */
  public static function staticFieldArgs(): array {
    return [
      ...parent::staticFieldArgs(),
      ...[
        self::FIELD_BONUS => static::conglomerateBonus()
      ]
    ];
  }

  /**
   * Returns the conglomerate bonus effect for this token
   * @return Effect
   */
  abstract protected static function conglomerateBonus(): Effect;

  /**
   * Claim the specific conglomerate bonus token for the given player
   * @param int $playerId
   * @return void
   */
  public function claim(int $playerId): void {
    $this->bonus->apply($playerId);
  }

  /** Constants - Field names */
  const FIELD_BONUS = "bonus";

  /** Constants - Metadata */
  const FILEPATH = "/../../../Token/Global/ConglomerateBonus/list.inc.php";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\Token\Global\ConglomerateBonus";
}