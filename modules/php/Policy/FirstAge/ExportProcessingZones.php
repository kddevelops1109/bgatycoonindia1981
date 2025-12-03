<?php
namespace Bga\Games\tycoonindianew\Policy\FirstAge;

use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\Card;
use Bga\Games\tycoonindianew\Model\Card\Policy\IndustrialPolicyCard;
use Bga\Games\tycoonindianew\Model\Card\Policy\PolicyCard;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\CardType;
use Bga\Games\tycoonindianew\Type\CardTypeArg;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\CardLocation;
use Bga\Games\tycoonindianew\Type\PolicyBenefitType;
use Bga\Games\tycoonindianew\Type\PolicyType;

/**
 * Export Processing Zones is an Industrial Policy Card that gives owners
 * - 2 influence during the Politics action
 * - A passive benefit of gaining a merit card if they lose an industry bidding
 * - 3 favor during endgame scoring
 */
class ExportProcessingZones extends IndustrialPolicyCard {

  public function __construct(int $cardLocationArg, int $cardPromoters) {
    $endgameInfluence = ["effectType" =>EffectType::GAIN, "fungibleType" => FT::INFLUENCE, "amount" => 1, "multiplier" => $this->endgameInfluenceMultiplier($cardLocationArg)];
    $politicsBonus = ["effectType" =>EffectType::GAIN, "fungibleType" => FT::PROMOTERS_IN_HAND, "amount" => 2, "multiplier" => 1];
    $endgameFavor = ["effectType" => EffectType::GAIN, "fungibleType" => FT::FAVOR, "amount" => 2, "multiplier" => 1];

    $args = [
      Card::FIELD_CARD_TYPE => CardType::POLICY,
      Card::FIELD_CARD_TYPE_ARG => CardTypeArg::AGE_I_POLICY,
      Card::FIELD_CARD_LOCATION => CardLocation::POLICY_DECK,
      Card::FIELD_CARD_LOCATION_ARG => $cardLocationArg,
      Card::FIELD_CARD_NAME => self::NAME,
      Card::FIELD_CARD_PROMOTERS => $cardPromoters,
      PolicyCard::FIELD_DESCRIPTION => self::DESCRIPTION,
      PolicyCard::FIELD_AGE => CardAge::AGE_I,
      PolicyCard::FIELD_TYPE => PolicyType::INDUSTRIAL,
      PolicyCard::FIELD_BENEFIT_TYPE => PolicyBenefitType::PASSIVE,
      PolicyCard::FIELD_BENEFIT => EffectRegistry::instance()->getOrCreate(
        EffectKeyGenerator::generate($endgameInfluence["effectType"], $endgameInfluence["fungibleType"], $endgameInfluence["amount"], $endgameInfluence["multiplier"]),
        $endgameInfluence
      ),
      PolicyCard::FIELD_POLITICS_BONUS => EffectRegistry::instance()->getOrCreate(
        EffectKeyGenerator::generate($politicsBonus["effectType"], $politicsBonus["fungibleType"], $politicsBonus["amount"], $politicsBonus["multiplier"]),
        $politicsBonus
      ),
      PolicyCard::FIELD_ENDGAME_FAVOR => EffectRegistry::instance()->getOrCreate(
        EffectKeyGenerator::generate($endgameFavor["effectType"], $endgameFavor["fungibleType"], $endgameFavor["amount"], $endgameFavor["amount"]),
        $endgameFavor
      )
    ];
    
    parent::__construct($args);
  }

  /**
   * Endgame influence multiplier - Number of plants on the map for given player
   * @param int $player_id
   * @return int
   */
  protected function applyEndgameInfluenceMultiplier(int $player_id): int {
    $multiplier = IndustrialistManager::getPlayerCounterValue($player_id, IndustrialistManager::COUNTER_INDUSTRIALIST_BUILT_PLANTS);
    if (is_null($multiplier)) {
      $multiplier = 0;
    }

    return $multiplier;
  }

  /**
   * Constants - Misc
   */

  const NAME = \clienttranslate("Export Processing Zones");
  const DESCRIPTION = \clienttranslate("Export Processing Zones (EPZs) were established in India in the 1960s as special economic zones with the aim of promoting exports, attracting foreign investment, and creating employment. The first EPZ was set up in Kandla, Gujarat in 1965.");
}