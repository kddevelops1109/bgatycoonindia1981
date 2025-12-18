<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Token\Global;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Type\Sector;

/**
 * Endgame favor tokens provide endgame favor based on the player's production of their sector
 * @property Sector $sector Industrial sector corresponding to this token
 * @property Effect $endgameSectorFavor Endgame sector favor given by this token
 */
abstract class EndgameSectorFavorToken extends GlobalToken {

  /**
   * Static fields list for endgame favor sectors
   * @return array<string>
   */
  public static function staticFieldsList(): array {
    return [
      ...parent::staticFieldsList(),
      ...[self::FIELD_SECTOR, self::FIELD_ENDGAME_SECTOR_FAVOR]
    ];
  }

  /**
   * Static field args for endgame favor sectors
   * @return array
   */
  public static function staticFieldArgs(): array {
    return [
      ...parent::staticFieldArgs(),
      ...[
        self::FIELD_SECTOR => static::SECTOR,
        self::FIELD_ENDGAME_SECTOR_FAVOR => static::endgameSectorFavor()
      ]
    ];
  }

  /**
   * Returns the endgame sector favor effect for this token
   * @return Effect
   */
  abstract protected static function endgameSectorFavor(): Effect;

  /**
   * Evaluate the specific endgame sector favor token for the given player
   * @param int $playerId
   * @return void
   */
  public function evaluate(int $playerId): void {
    $this->endgameSectorFavor->apply($playerId);
  }

  /** Constants - Field names */
  const FIELD_SECTOR = "sector";
  const FIELD_ENDGAME_SECTOR_FAVOR = "endgameSectorFavor";

  /** Constants - Metadata */
  const FILEPATH = "/../../../Token/Global/EndgameSectorFavor/list.inc.php";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\Token\Global\EndgameSectorFavor";
}