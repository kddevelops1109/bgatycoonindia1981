<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Card\Policy;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Card;
use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\PolicyBenefitType;
use Bga\Games\tycoonindianew\Type\PolicyType;

/**
 * Policy Card
 * @property string $description Policy description
 * @property CardAge $age Age I/II policy
 * @property PolicyType $type Policy type (Economic/Industrial/Liberal)
 * @property PolicyBenefitType $benefitType Policy benefit type (Immediate/Passive/Endgame Bonus)
 * @property Effect $benefit Policy benefit
 * @property Effect $politicsBonus Politics bonus of policy
 * @property Effect $endgameFavor Endgame favor provided by policy
 */
abstract class PolicyCard extends Card {

  /**
   * Politics bonus given by this policy card
   * @return Effect
   */
  abstract public static function politicsBonus(): Effect;

  /**
   * Endgame favor given by this policy card
   * @return Effect
   */
  abstract public static function endgameFavor(): Effect;

  /**
   * Policy cards can be gained
   * @return bool
   */
  public function canBeGained(): bool {
    return true;
  }

  /**
   * Policy cards cannot be lost once gained
   * @return bool
   */
  public function canBeLost(): bool {
    return false;
  }

  /**
   * List of static fields for policy card
   * @return array<string>
   */
  public static function staticFieldsList(): array {
    return [
      ...[self::FIELD_DESCRIPTION, self::FIELD_AGE, self::FIELD_TYPE, self::FIELD_BENEFIT_TYPE, self::FIELD_BENEFIT, self::FIELD_POLITICS_BONUS, self::FIELD_ENDGAME_FAVOR],
      ...parent::staticFieldsList()
    ];
  }

  /**
   * Common static field args for policy cards, if any
   * @param int $player_id
   * @return array
   */
  public static function staticFieldArgs(): array {
    return [
      ...parent::staticFieldArgs(),
      ...[
        self::FIELD_DESCRIPTION => static::DESCRIPTION,
        self::FIELD_AGE => static::AGE,
        self::FIELD_TYPE => static::TYPE,
        self::FIELD_BENEFIT_TYPE => static::BENEFIT_TYPE,
        self::FIELD_POLITICS_BONUS => static::politicsBonus(),
        self::FIELD_ENDGAME_FAVOR => static::endgameFavor()
      ]
    ];
  }

  /**
   * Constants - Static Fields
   */
  const FIELD_DESCRIPTION = "description";
  const FIELD_AGE = "age";
  const FIELD_TYPE = "type";
  const FIELD_BENEFIT_TYPE = "benefitType";
  const FIELD_BENEFIT = "benefit";
  const FIELD_POLITICS_BONUS = "politicsBonus";
  const FIELD_ENDGAME_FAVOR = "endgameFavor";

  /**
   * Constants - Filepath and Classpath
   */
  const FILEPATH_AGE_I = "/../../Policy/FirstAge/list.inc.php";
  const FILEPATH_AGE_II = "/../../Policy/SecondAge/list.inc.php";
  
  const CLASSPATH_AGE_I = "\Bga\Games\\tycoonindianew\Policy\FirstAge";
  const CLASSPATH_AGE_II = "\Bga\Games\\tycoonindianew\Policy\SecondAge";

  /** Constants - Misc */
  const NBR = 1;
}