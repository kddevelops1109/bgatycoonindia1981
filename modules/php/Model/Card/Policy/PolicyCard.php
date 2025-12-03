<?php
namespace Bga\Games\tycoonindianew\Model\Card\Policy;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Model\Card\Card;
use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\PolicyBenefitType;
use Bga\Games\tycoonindianew\Type\PolicyType;

/**
 * Policy Card
 * @property string $description Policy description
 * @property string $age Age I/II policy
 * @property PolicyType $type Policy type (Economic/Industrial/Liberal)
 * @property PolicyBenefitType $benefitType Policy benefit type (Immediate/Passive/Endgame Bonus)
 * @property Effect $benefit Policy benefit
 * @property Effect $politicsBonus Politics bonus of policy
 * @property Effect $endgameFavor Endgame favor provided by policy
 */
abstract class PolicyCard extends Card {

  /**
   * Policy cards do not give endgame asset value
   * @return void
   */
  public function applyEndgameAssetValue(int $player_id): void {
    // Do nothing
  }

  /**
   * Endgame favor of policy cards
   * @return void
   */
  public function applyEndgameFavor(int $player_id): void {
    if ($this->cardLocationArg == $player_id) {
      $this->endgameFavor->apply($player_id);
    }
  }

  /**
   * Apply the politics bonus of this card to the given player, if they own this policy card
   * @param int $player_id
   * @return void
   */
  public function applyPoliticsBonus(int $player_id): void {
    if ($this->cardLocationArg == $player_id) {
      $this->politicsBonus->apply($player_id);
    }
  }

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

  protected static function staticFieldsList() {
    return [
      self::FIELD_DESCRIPTION,
      self::FIELD_AGE,
      self::FIELD_TYPE,
      self::FIELD_BENEFIT_TYPE,
      self::FIELD_BENEFIT,
      self::FIELD_POLITICS_BONUS,
      self::FIELD_ENDGAME_FAVOR
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
}