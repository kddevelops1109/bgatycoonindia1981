<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Card;

use Bga\Games\tycoonindianew\Model\DeckItem\DeckItem;

use Bga\Games\tycoonindianew\Type\DataType as DT;

/**
 * Represents all Tycoon Cards. These are Corporate Agendas, Policies, Industries and Merits
 * @property int $cardPromoters Number of promoters on this card
 */
abstract class Card extends DeckItem {

  /**
   * DB Field mappings common to all cards
   * @return array{column: string, name: string, readOnly: bool, type: DT[]}
   */
  public static function dbFieldMappings(): array {
    return [
      ...parent::dbFieldMappings(),
      ...[
        self::COLUMN_CARD_PROMOTERS => ["name" => self::FIELD_CARD_PROMOTERS, "type" => DT::INT, "column" => self::COLUMN_CARD_PROMOTERS, "readOnly" => false]
      ]
    ];
  }

  /** Play methods */

  // abstract public function play();

  /** Constants - DB field names */
  const FIELD_CARD_PROMOTERS = "cardPromoters";

  /** Constants - DB column names */
  const COLUMN_CARD_PROMOTERS = "promoters";

  /** Constants - Misc */
  const TABLE_NAME = "tycoon_card";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\Model\DeckItem\Card\\";
}