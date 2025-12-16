<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Card\Merit;

use Bga\Games\tycoonindianew\Effect\Effect;

/**
 * Merit cards that have only one effect associated with them
 * @property Effect $benefit Single benefit given by this merit card
 */
abstract class SingleEffectMeritCard extends MeritCard {

  /**
   * Benefit given by specific single effect merit card
   * @return Effect
   */
  abstract public static function benefit(): Effect;

  /**
   * Static field list for this single effect merit card
   * @return array<string>
   */
  public static function staticFieldsList(): array {
    return [
      ...parent::staticFieldsList(),
      ...[self::FIELD_BENEFIT]
    ];
  }

  /**
   * Static field args for this single effect merit card
   * @return array
   */
  public static function staticFieldArgs(): array {
    return [
      ...parent::staticFieldArgs(),
      ...[self::FIELD_BENEFIT => static::benefit()]
    ];
  }

  /** Constants - Field names */
  const FIELD_BENEFIT = "benefit";
}