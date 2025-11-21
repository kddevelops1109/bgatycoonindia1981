<?php
namespace Bga\Games\tycoonindianew\Models;

use Bga\GameFramework\Components\Counters\PlayerCounter;

/**
 * Class representing an industrialist (player)
 * @property int $id
 * @property int $no
 * @property string $name
 * @property string $color
 * @property string $colorName
 * @property bool $eliminated
 * @property int $score
 * @property int $scoreAux
 * @property bool $zombie
 * @property bool $isTycoon
 * @property bool $isNextTycoon
 * @property PlayerCounter $influence
 * @property int $influenceRank
 * @property PlayerCounter $assetValue
 * @property PlayerCounter $money
 * @property PlayerCounter $favor
 * @property PlayerCounter $promotersInHand
 * @property PlayerCounter $promotersInPool
 * @property PlayerCounter $promissaryNotes
 * @property PlayerCounter $loanIntakeLevel
 * @property PlayerCounter $finance
 * @property PlayerCounter $financeRank
 * @property PlayerCounter $minerals
 * @property int $mineralsRank
 * @property PlayerCounter $fuel
 * @property int $fuelRank
 * @property PlayerCounter $agro
 * @property int $agroRank
 * @property PlayerCounter $power
 * @property int $powerRank
 * @property PlayerCounter $transport
 * @property int $transportRank
 * @property PlayerCounter $actionsRemaining
 * @property PlayerCounter $plusOneActionsRemaining
 * @property PlayerCounter $tycoonActionsRemaining
 */
class Industrialist extends DBObject {
  
  /**
   * Name of table
   * @var string
   */
  protected $table = "player";

  /**
   * Name, type and column of the primary key field
   * @var array
   */
  protected $primaryKey = ["name" => "no", "type" => "int", "column" => "player_no"];

  /**
   * Fields that will be stored in the database
   * @var array
   */
  protected $dbFields = [
    ["name" => "id", "type" => "int", "column" => self::COLUMN_PLAYER_ID, "readOnly" => true],
    ["name" => "no", "type" => "int", "column" => self::COLUMN_PLAYER_NO, "readOnly" => true],
    ["name" => "name", "type" => "string", "column" => self::COLUMN_PLAYER_NAME, "readOnly" => true],
    ["name" => "color", "type" => "string", "column" => self::COLUMN_PLAYER_COLOR, "readOnly" => true],
    ["name" => "colorName", "type" => "string", "column" => self::COLUMN_PLAYER_COLOR_NAME, "readOnly" => false],
    ["name" => "eliminated", "type" => "bool", "column" => self::COLUMN_PLAYER_ELIMINATED, "readOnly" => true],
    ["name" => "score", "type" => "int", "column" => self::COLUMN_PLAYER_SCORE, "readOnly" => false],
    ["name" => "scoreAux", "type" => "int", "column" => self::COLUMN_PLAYER_SCORE_AUX, "readOnly" => false],
    ["name" => "zombie", "type" => "int", "column" => self::COLUMN_PLAYER_ZOMBIE, "readOnly" => false],
    ["name" => "isTycoon", "type" => "bool", "column" => self::COLUMN_PLAYER_IS_TYCOON, "readOnly" => false],
    ["name" => "isNextTycoon", "type" => "bool", "column" => self::COLUMN_PLAYER_IS_NEXT_TYCOON, "readOnly" => false],
    ["name" => "influence", "type" => "int", "column" => self::COLUMN_PLAYER_INFLUENCE, "readOnly" => false],
    ["name" => "influenceRank", "type" => "int", "column" => self::COLUMN_PLAYER_INFLUENCE_RANK, "readOnly" => false],
    ["name" => "assetValue", "type" => "int", "column" => self::COLUMN_PLAYER_ASSET_VALUE, "readOnly" => false],
    ["name" => "favor", "type" => "int", "column" => self::COLUMN_PLAYER_FAVOR, "readOnly" => false],
    ["name" => "money", "type" => "int", "column" => self::COLUMN_PLAYER_MONEY, "readOnly" => false],
    ["name" => "promotersInHand", "type" => "int", "column" => self::COLUMN_PLAYER_PROMOTERS_IN_HAND, "readOnly" => false],
    ["name" => "promotersInPool", "type" => "int", "column" => self::COLUMN_PLAYER_PROMOTERS_IN_POOL, "readOnly" => false],
    ["name" => "promissaryNotes", "type" => "int", "column" => self::COLUMN_PLAYER_PROMISSARY_NOTES, "readOnly" => false],
    ["name" => "loanIntakeLevel", "type" => "int", "column" => self::COLUMN_PLAYER_LOAN_INTAKE_LEVEL, "readOnly" => false],
    ["name" => "finance", "type" => "int", "column" => self::COLUMN_PLAYER_FINANCE, "readOnly" => false],
    ["name" => "financeRank", "type" => "int", "column" => self::COLUMN_PLAYER_FINANCE_RANK, "readOnly" => false],
    ["name" => "minerals", "type" => "int", "column" => self::COLUMN_PLAYER_MINERALS, "readOnly" => false],
    ["name" => "mineralsRank", "type" => "int", "column" => self::COLUMN_PLAYER_MINERALS_RANK, "readOnly" => false],
    ["name" => "fuel", "type" => "int", "column" => self::COLUMN_PLAYER_FUEL, "readOnly" => false],
    ["name" => "fuelRank", "type" => "int", "column" => self::COLUMN_PLAYER_FUEL_RANK, "readOnly" => false],
    ["name" => "agro", "type" => "int", "column" => self::COLUMN_PLAYER_AGRO, "readOnly" => false],
    ["name" => "agroRank", "type" => "int", "column" => self::COLUMN_PLAYER_AGRO_RANK, "readOnly" => false],
    ["name" => "power", "type" => "int", "column" => self::COLUMN_PLAYER_POWER, "readOnly" => false],
    ["name" => "powerRank", "type" => "int", "column" => self::COLUMN_PLAYER_POWER_RANK, "readOnly" => false],
    ["name" => "transport", "type" => "int", "column" => self::COLUMN_PLAYER_TRANSPORT, "readOnly" => false],
    ["name" => "transportRank", "type" => "int", "column" => self::COLUMN_PLAYER_TRANSPORT_RANK, "readOnly" => false],
    ["name" => "actionsRemaining", "type" => "int", "column" => self::COLUMN_PLAYER_ACTIONS_REMAINING, "readOnly" => false],
    ["name" => "plusOneActionsRemaining", "type" => "int", "column" => self::COLUMN_PLAYER_PLUS_ONE_ACTIONS_REMAINING, "readOnly" => false],
    ["name" => "tycoonActionsRemaining", "type" => "bool", "column" => self::COLUMN_PLAYER_TYCOON_ACTIONS_REMAINING, "readOnly" => false]
  ];

  /**
   * Constants - DB Columns
   */

  const COLUMN_PLAYER_ID = "player_id";
  const COLUMN_PLAYER_NO = "player_no";
  const COLUMN_PLAYER_NAME = "player_name";
  const COLUMN_PLAYER_COLOR = "player_color";
  const COLUMN_PLAYER_COLOR_NAME = "player_color_name";
  const COLUMN_PLAYER_ELIMINATED = "player_eliminated";
  const COLUMN_PLAYER_SCORE = "player_score";
  const COLUMN_PLAYER_SCORE_AUX = "player_score_aux";
  const COLUMN_PLAYER_ZOMBIE = "player_zombie";
  const COLUMN_PLAYER_IS_TYCOON = "player_is_tycoon";
  const COLUMN_PLAYER_IS_NEXT_TYCOON = "player_is_next_tycoon";
  const COLUMN_PLAYER_INFLUENCE = "player_influence";
  const COLUMN_PLAYER_INFLUENCE_RANK = "player_influence_rank";
  const COLUMN_PLAYER_ASSET_VALUE = "player_asset_value";
  const COLUMN_PLAYER_FAVOR = "player_favor";
  const COLUMN_PLAYER_MONEY = "player_money";
  const COLUMN_PLAYER_PROMOTERS_IN_HAND = "player_promoters_in_hand";
  const COLUMN_PLAYER_PROMOTERS_IN_POOL = "player_promoters_in_pool";
  const COLUMN_PLAYER_PROMISSARY_NOTES = "player_promissary_notes";
  const COLUMN_PLAYER_LOAN_INTAKE_LEVEL = "player_loan_intake_level";
  const COLUMN_PLAYER_FINANCE = "player_finance";
  const COLUMN_PLAYER_FINANCE_RANK = "player_finance_rank";
  const COLUMN_PLAYER_MINERALS = "player_minerals";
  const COLUMN_PLAYER_MINERALS_RANK = "player_minerals_rank";
  const COLUMN_PLAYER_FUEL = "player_fuel";
  const COLUMN_PLAYER_FUEL_RANK = "player_fuel_rank";
  const COLUMN_PLAYER_AGRO = "player_agro";
  const COLUMN_PLAYER_AGRO_RANK = "player_agro_rank";
  const COLUMN_PLAYER_POWER = "player_power";
  const COLUMN_PLAYER_POWER_RANK = "player_power_rank";
  const COLUMN_PLAYER_TRANSPORT = "player_transport";
  const COLUMN_PLAYER_TRANSPORT_RANK = "player_transport_rank";
  const COLUMN_PLAYER_ACTIONS_REMAINING = "player_actions_remaining";
  const COLUMN_PLAYER_PLUS_ONE_ACTIONS_REMAINING = "player_plus_one_actions_remaining";
  const COLUMN_PLAYER_TYCOON_ACTIONS_REMAINING = "player_tycoon_actions_remaining";
}