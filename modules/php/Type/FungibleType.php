<?php
namespace Bga\Games\tycoonindianew\Type;

use Bga\Games\tycoonindianew\Fungible\FungibleMetadata;
use Bga\Games\tycoonindianew\Manager\IndustrialistManager;

enum FungibleType: string {
  case INFLUENCE = "Influence";
  case MONEY = "Money";
  case ASSET_VALUE = "Asset Value";
  case FAVOR = "Favor";
  case PROMOTERS_IN_HAND = "Promoters in Hand";
  case PROMOTERS_IN_POOL = "Promoters in Pool";
  case FINANCE = "Finance";
  case MINERALS = "Minerals";
  case FUEL = "Fuel";
  case AGRO = "Agro";
  case POWER = "Power";
  case TRANSPORT = "Transport";
  case CORPORATE_AGENDA = "Corporate Agenda";
  case POLICY = "Policy";
  case INDUSTRY = "Industry";
  case MERIT = "Merit";
  case PROMISSARY_NOTE = "Promissary Note";
  case CONGLOMERATE_BONUS = "Conglomerate Bonus";
  case ACTION_TOKEN = "Action";
  case TYCOON_ACTION = "Tycoon Action";
  case PLUS_ONE_ACTION = "+1 Action";
  case PLANT = "Plant";
  case SECTOR_PRODUCTION = "Sector Production";

  public function meta(): FungibleMetadata {
    return match($this) {
      self::INFLUENCE => new FungibleMetadata(true, true, IndustrialistManager::COUNTER_INDUSTRIALIST_INFLUENCE),
      self::MONEY => new FungibleMetadata(true, true, IndustrialistManager::COUNTER_INDUSTRIALIST_MONEY),
      self::ASSET_VALUE => new FungibleMetadata(true, false, IndustrialistManager::COUNTER_INDUSTRIALIST_ASSET_VALUE),
      self::FAVOR => new FungibleMetadata(true, false, IndustrialistManager::COUNTER_INDUSTRIALIST_FAVOR),
      self::PROMOTERS_IN_HAND => new FungibleMetadata(true, true, IndustrialistManager::COUNTER_INDUSTRIALIST_PROMOTERS_IN_HAND),
      self::PROMOTERS_IN_POOL => new FungibleMetadata(true, true, IndustrialistManager::COUNTER_INDUSTRIALIST_PROMOTERS_IN_POOL),
      self::FINANCE => new FungibleMetadata(true, false, IndustrialistManager::COUNTER_INDUSTRIALIST_FINANCE),
      self::MINERALS => new FungibleMetadata(true, false, IndustrialistManager::COUNTER_INDUSTRIALIST_MINERALS),
      self::FUEL => new FungibleMetadata(true, false, IndustrialistManager::COUNTER_INDUSTRIALIST_FUEL),
      self::AGRO => new FungibleMetadata(true, false, IndustrialistManager::COUNTER_INDUSTRIALIST_AGRO),
      self::POWER => new FungibleMetadata(true, false, IndustrialistManager::COUNTER_INDUSTRIALIST_POWER),
      self::TRANSPORT => new FungibleMetadata(true, false, IndustrialistManager::COUNTER_INDUSTRIALIST_TRANSPORT),
      self::CORPORATE_AGENDA => new FungibleMetadata(true, false, null),
      self::POLICY => new FungibleMetadata(true, false, IndustrialistManager::COUNTER_INDUSTRIALIST_POLICIES_GAINED),
      self::INDUSTRY => new FungibleMetadata(true, false, IndustrialistManager::COUNTER_INDUSTRIALIST_INDUSTRIES_PURCHASED),
      self::MERIT => new FungibleMetadata(true, true, IndustrialistManager::COUNTER_INDUSTRIALIST_MERITS_IN_HAND),
      self::CONGLOMERATE_BONUS => new FungibleMetadata(true, false, null),
      self::PROMISSARY_NOTE => new FungibleMetadata(true, true, IndustrialistManager::COUNTER_INDUSTRIALIST_PROMISSARY_NOTES),
      self::ACTION_TOKEN => new FungibleMetadata(true, true, IndustrialistManager::COUNTER_INDUSTRIALIST_ACTIONS_REMAINING),
      self::PLUS_ONE_ACTION => new FungibleMetadata(true, true, IndustrialistManager::COUNTER_INDUSTRIALIST_PLUS_ONE_ACTIONS_REMAINING),
      self::TYCOON_ACTION => new FungibleMetadata(true, true, IndustrialistManager::COUNTER_INDUSTRIALIST_TYCOON_ACTIONS_REMAINING),
      self::PLANT => new FungibleMetadata(false, false, null),
      self::SECTOR_PRODUCTION => new FungibleMetadata(false, false, null)
    };
  }
}