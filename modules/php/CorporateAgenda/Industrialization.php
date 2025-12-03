<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\Gain;
use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\CorporateAgendaCard;
use Bga\Games\tycoonindianew\Registry\EffectRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class Industrialization extends CorporateAgendaCard {

  /**
   * Returns the end game favor this corporate agenda card gives to eligible player(s)
   * @return int End game favor
   */
  public function applyEndgameFavor(int $player_id): void {
    $favor = 0;

    if (!is_null($player_id)) {
      $built_plants = (int) IndustrialistManager::getPlayerCounterValue($player_id, IndustrialistManager::COUNTER_INDUSTRIALIST_BUILT_PLANTS);
      foreach (self::ENDGAME_FAVOR as $threshold => $_favor) {
        if ($built_plants >= $threshold) {
          $favor = $_favor;
        }
        else {
          break;
        }
      }
      $this->applyEndgameFavorEffect($player_id, $favor);
    }
  }
  
  /**
   * Constants - Misc
   */
  const NAME = "Industrialization";
  const DESCRIPTION = "Build a lot of plants on the map";
  const ENDGAME_FAVOR = [6 => 1, 7 => 4, 9 => 7, 9 => 11];
}