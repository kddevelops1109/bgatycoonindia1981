<?php
namespace Bga\Games\tycoonindianew\Effect;

use Bga\Games\tycoonindianew\Condition\Condition;
use Bga\Games\tycoonindianew\Condition\NullCondition;
use Bga\Games\tycoonindianew\Spec\NullSpec;

use Bga\Games\tycoonindianew\Dispatcher\EffectDispatcher;

use Bga\Games\tycoonindianew\Registry\Entry;

use Bga\Games\tycoonindianew\Spec\Spec;

use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Effect is a gain or loss of a particular type of fungible by a certain amount
 * An effect can be one of two types - gain or loss
 * It can be entered into its own registry
 */
abstract class Effect implements Entry {

  public function __construct(
    public readonly FT $fungibleType,
    public readonly int $amount,
    public ?Condition $condition,
    public ?Spec $spec,
    public readonly int $multiplier = 1,
    public readonly bool $roundDown = false
  ) {
    $this->condition = $condition ?? NullCondition::get();
    $this->spec = $spec ?? NullSpec::get();
  }

  /**
   * Apply this effect for given player
   * @param $player_id Player to whom this effect is to be applied
   * @return void
   */
  public function apply(int $player_id) {
    EffectDispatcher::instance()->dispatch($player_id, $this);
  }
}