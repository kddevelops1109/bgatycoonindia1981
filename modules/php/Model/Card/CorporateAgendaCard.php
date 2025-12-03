<?php
namespace Bga\Games\tycoonindianew\Model\Card;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Registry\EffectRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Represents corporate agenda cards that return endgame favor to owners based on conditions
 */
abstract class CorporateAgendaCard extends Card {

  /**
   * Corporate agendas do not have any static fields
   * @return array
   */
  public static function staticFieldsList(): array {
    return [];
  }

  public static function staticFieldArgs(): array {
    return [];
  }

  /**
   * Returns 0 as corporate agenda cards do not give any end game asset value
   * @return int End game asset value
   */
  public function applyEndgameAssetValue(int $player_id): void {
    // Do nothing
  }

  /**
   * Returns 0 as corporate agenda cards do not give any end game influence
   * @return int End game influence
   */
  public function applyEndgameInfluence(int $player_id): void {
    // Do nothing
  }

  /**
   * Apply the computed endgame favor effect to the given player
   * @param int $player_id
   * @param int $favor
   * @return void
   */
  protected function applyEndgameFavorEffect(int $player_id, int $favor): void {
    $this->applyEndgameEffect($player_id, FT::FAVOR, $favor);
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

  const FILEPATH = "/../../CorporateAgenda/list.inc.php";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\CorporateAgenda";
}