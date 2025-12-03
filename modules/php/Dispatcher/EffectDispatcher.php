<?php
namespace Bga\Games\tycoonindianew\Dispatcher;

use InvalidArgumentException;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Executor\Effect\AgroEffectExecutor;
use Bga\Games\tycoonindianew\Executor\Effect\AssetValueEffectExecutor;
use Bga\Games\tycoonindianew\Executor\Effect\FavorEffectExecutor;
use Bga\Games\tycoonindianew\Executor\Effect\FinanceEffectExecutor;
use Bga\Games\tycoonindianew\Executor\Effect\FuelEffectExecutor;
use Bga\Games\tycoonindianew\Executor\Effect\InfluenceEffectExecutor;
use Bga\Games\tycoonindianew\Executor\Effect\MineralsEffectExecutor;
use Bga\Games\tycoonindianew\Executor\Effect\MoneyEffectExecutor;
use Bga\Games\tycoonindianew\Executor\Effect\PowerEffectExecutor;
use Bga\Games\tycoonindianew\Executor\Effect\PromotersInHandEffectExecutor;
use Bga\Games\tycoonindianew\Executor\Effect\PromotersInPoolEffectExecutor;
use Bga\Games\tycoonindianew\Executor\Effect\TransportEffectExecutor;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class EffectDispatcher extends Dispatcher {

  /**
   * Dispatches a request to execute the given effect for given player, if any
   * @param int|null $player_id
   * @param mixed $payload
   * @return void
   */
  public function dispatch(?int $player_id, mixed $payload = null): void {
    if (!$payload instanceof Effect) {
      throw new InvalidArgumentException("Payload for EffectDispatcher must be an Effect");
    }

    $executor = match ($payload->fungibleType) {
        FT::INFLUENCE => InfluenceEffectExecutor::instance(),
        FT::MONEY => MoneyEffectExecutor::instance(),
        FT::ASSET_VALUE => AssetValueEffectExecutor::instance(),
        FT::FAVOR => FavorEffectExecutor::instance(),
        FT::PROMOTERS_IN_HAND => PromotersInHandEffectExecutor::instance(),
        FT::PROMOTERS_IN_POOL => PromotersInPoolEffectExecutor::instance(),
        FT::FINANCE => FinanceEffectExecutor::instance(),
        FT::MINERALS => MineralsEffectExecutor::instance(),
        FT::FUEL => FuelEffectExecutor::instance(),
        FT::AGRO => AgroEffectExecutor::instance(),
        FT::POWER => PowerEffectExecutor::instance(),
        FT::TRANSPORT => TransportEffectExecutor::instance(),
        default => throw new \LogicException("Unhandled fungible type")
    };

    $executor->execute($player_id, $payload);
  }
}