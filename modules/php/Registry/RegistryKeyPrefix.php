<?php
namespace Bga\Games\tycoonindianew\Registry;

enum RegistryKeyPrefix: string {
    /** Search key prefixes */
    case SEARCH_PLAYER_ID = 'search_player_id';

    /** Card searches */
    case SEARCH_CARD_TYPE = 'search_card_type';
    case SEARCH_CARD_LOCATION = 'search_card_location';
    case SEARCH_CARD_LOCATION_ARG = 'search_card_location_arg';
    case SEARCH_CARD_IN_DECK = 'search_card_in_deck';
    case SEARCH_CARD_BY_ID = 'search_card_by_id';
    case SEARCH_CARD_BY_NAME = 'search_card_by_name';

    /** Deck item searches */
    case SEARCH_DECK_ITEM_TYPE = 'search_deck_item_type';
    case SEARCH_DECK_ITEM_LOCATION = 'search_deck_item_location';
    case SEARCH_DECK_ITEM_LOCATION_ARG = 'search_deck_item_location_arg';
    case SEARCH_DECK_ITEM_IN_DECK = 'search_deck_item_in_deck';
    case SEARCH_DECK_ITEM_BY_ID = 'search_deck_item_by_id';
    case SEARCH_DECK_ITEM_BY_NAME = 'search_deck_item_by_name';
    
    /** Gain effect key prefixes */
    case GAIN_EFFECT = 'gain';

    /** Loss effect key prefixes */
    case LOSE_EFFECT = 'lose';
    case SPEND_EFFECT = 'spend';

    /** Misc key prefixes */
    case NULL_CONDITION = 'nullCondition';

    /**
     * Is the given key valid?
     * @param string $key
     * @return bool
     */
    public static function isValid(string $key) {
      foreach (self::cases() as $prefix) {
        if (str_starts_with($key, $prefix->value)) {
          return true;
        }
      }

      return false;
    }
}
