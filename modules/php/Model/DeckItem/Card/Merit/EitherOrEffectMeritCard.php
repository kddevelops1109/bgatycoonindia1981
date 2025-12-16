<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Card\Merit;

use Bga\Games\tycoonindianew\Effect\Effect;

/**
 * These merit cards provide 2 effects, of which only one can be applied by the player, as desired by them
 * @property array<Effect> $benefits;
 */
abstract class EitherOrEffectMeritCard extends MeritCard {

  /**
   * Benefits given by specific either or effect merit card
   * @return array<Effect>
   */
  abstract public static function benefits(): array;

  /**
   * Static field list for this single effect merit card
   * @return array<string>
   */
  public static function staticFieldsList(): array
  {
    return [
      ...parent::staticFieldsList(),
      ...[self::FIELD_BENEFITS]
    ];
  }

  /**
   * Static field args for this single effect merit card
   * @return array
   */
  public static function staticFieldArgs(): array
  {
    return [
      ...parent::staticFieldArgs(),
      ...[self::FIELD_BENEFITS => static::benefits()]
    ];
  }

  /** Constants - Field names */
  const FIELD_BENEFITS = "benefits";
}