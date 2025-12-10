<?php
namespace Bga\Games\tycoonindianew\Effect;

use Bga\Games\tycoonindianew\Condition\Condition;
use Bga\Games\tycoonindianew\Condition\NullCondition;

use Bga\Games\tycoonindianew\Contracts\Triggerable;

use Bga\Games\tycoonindianew\Dispatcher\EffectDispatcher;

use Bga\Games\tycoonindianew\Multiplier\Multiplier;
use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\Entry;

use Bga\Games\tycoonindianew\Spec\NullSpec;
use Bga\Games\tycoonindianew\Spec\Spec;

use Bga\Games\tycoonindianew\Trigger\TriggerDefinition;

use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Effect is a gain or loss of a particular type of fungible by a certain amount
 * An effect can be one of two types - gain or loss
 * It can be entered into its own registry
 */
abstract class Effect implements Entry, Triggerable {

  public function __construct(
    public readonly FT $fungibleType,
    public readonly int $amount,
    public ?Multiplier $multiplier,
    public ?Condition $condition,
    public ?Spec $spec,
    public ?Effect $next,
    public ?TriggerDefinition $trigger,
    public readonly bool $roundDown = false
  ) {
    $this->condition = $condition ?? NullCondition::get();
    $this->spec = $spec ?? NullSpec::get();
    $this->multiplier = $multiplier ?? StaticMultiplier::instance(1);

    if ($trigger != null) {
      $trigger->target = $this;
    }
  }

  /**
   * Trigger point for the trigger manager to apply this effect.
   * Non-triggered effects can be directly applied instead.
   * Both methods serve the same purpose (as fire calls apply), and this is more for semantics.
   * @param int $playerId
   * @return void
   */
  public function fire(int $playerId): void {
    $this->apply($playerId);
  }

  /**
   * Apply this effect for given player
   * @param $playerId Player to whom this effect is to be applied
   * @return void
   */
  public function apply(int $playerId): void {
    EffectDispatcher::instance()->dispatch($playerId, $this, false);

    // If, there is a next effect to apply, then do so
    if ($this->next != null) {
      $this->next->apply($playerId);
    }
  }

  /**
   * Preview the result of this effect for given player, without applying it
   * @param $playerId Player to whom this effect is to be previewed
   * @return int
   */
  public function preview(int $playerId): int {
    return EffectDispatcher::instance()->dispatch($playerId, $this, true);
  }
}