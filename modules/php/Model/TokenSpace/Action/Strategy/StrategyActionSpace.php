<?php
namespace Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Model\TokenSpace\Action\ActionSpace;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;

use Bga\Games\tycoonindianew\Type\DataType as DT;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

use Bga\Games\tycoonindianew\Util\StringUtil;
use InvalidArgumentException;

/**
 * Represents a strategy action space
 * @property Effect $cost Number of promoters in the strategy pool to spend to be able to occupy this space, as an effect
 * @property Effect $reward Reward for occupying this strategy action space
 * @property ?int $shareValue Value of share token occupying this space, if any
 */
abstract class StrategyActionSpace extends ActionSpace {

  /**
   * Static array of instances
   * @var array
   */
  public static array $instances = [];

  final public static function instance($args): static {
    $spaceId = self::generateSpaceId($args);
    $args["spaceId"] = $spaceId;

    if(!array_key_exists($spaceId, static::$instances)) {
      static::$instances[$spaceId] = new static($args);
    }

    return static::$instances[$spaceId];
  }

  public static function dbFieldMappings(): array {
    return [...parent::dbFieldMappings(), ...[self::COLUMN_SHARE_VALUE => ["column" => self::COLUMN_SHARE_VALUE, "name" => self::FIELD_SHARE_VALUE, "type" => DT::INT, "readOnly" => false]]];
  }

  public static function staticFieldsList(): array {
    return [...parent::staticFieldsList(), ...[self::FIELD_COST, self::FIELD_REWARD]];
  }

  /**
   * Generate space id for given args
   * @param array|null $args
   * @return string
   */
  public static function generateSpaceId(?array $args): string {
    $class = static::class;
    
    if (is_null($args) || !array_key_exists(self::FIELD_COST, $args) || !array_key_exists(self::FIELD_REWARD, $args)) {
      throw new InvalidArgumentException("Args must have cost and reward for " . $class);
    }
    
    $cost = $args[self::FIELD_COST];
    $reward = $args[self::FIELD_REWARD];

    $index = -1;
    if (array_key_exists("index", $args)) {
      $index = (int) $args["index"];
    }

    $components = [
      str_replace("strategy-action-space-", "", StringUtil::classToKebab($class)),
      $cost->amount,
      str_replace(" ", "-", strtolower(FT::PROMOTERS_IN_POOL->value)),
      $reward->amount,
      str_replace(" ", "-", strtolower($reward->fungibleType->value))
    ];

    if ($index > 0) {
      $components[] = $index;
    }

    return implode("-", $components);
  }

  /**
   * Generate and register effect for given number of promoters in pool. This ensures that the Effect is registered, and we just retrieve the registered effect if already entered into the effect registry.
   * @param int $cost
   * @return Effect
   */
  public static function generateCost(int $cost): Effect {
    return EffectRegistry::instance()->getOrCreate(
      RegistryKeyPrefix::LOSE_EFFECT->value . "_" . $cost . str_replace("_", "-", strtolower(FT::PROMOTERS_IN_POOL->value)),
      ["type" => EffectType::LOSS, "fungibleType" => FT::PROMOTERS_IN_POOL, "amount" => $cost, "condition" => null, "spec" => null, "multiplier" => 1, "roundDown" => false]
    );
  }

  /**
   * Generate and register effect for given reward. This ensures that the Effect is registered, and we just retrieve the registered effect if already entered into the effect registry.
   * @param FT $fungibleType
   * @param int $amount
   * @return Effect
   */
  public static function generateReward(FT $fungibleType, int $amount): Effect {
    return EffectRegistry::instance()->getOrCreate(
      RegistryKeyPrefix::GAIN_EFFECT->value . "_" . $amount . str_replace("_", "-", strtolower($fungibleType->value)),
      ["type" => EffectType::GAIN, "fungibleType" => $fungibleType, "amount" => $amount, "condition" => null, "spec" => null, "multiplier" => 1, "roundDown" => false]
    );
  }

  /**
   * Constants - Misc
   */
  const TABLE_NAME = "tycoon_strategy_action_space";

  /**
   * Constants - DB Columns
   */
  const COLUMN_SHARE_VALUE = "share_value";

  /**
   * Constants - Fields
   */
  const FIELD_COST = "cost";
  const FIELD_REWARD = "reward";
  const FIELD_SHARE_VALUE = "shareValue";
}