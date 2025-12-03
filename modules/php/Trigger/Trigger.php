<?php
namespace Bga\Games\tycoonindianew\Trigger;

use Bga\Games\tycoonindianew\Model\DBObject as DBO;

/**
 * Represents a game trigger
 * @property string $id ID of the trigger
 * @property string $condition Condition, if any, that needs to be satisfied for this trigger to be applied
 */
abstract class Trigger extends DBO {

}