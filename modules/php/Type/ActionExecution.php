<?php
namespace Bga\Games\tycoonindianew\Type;

/**
 * Determines whether an action is manual or automatic
 */
enum ActionExecution: string {
  /** Represents actions that need to be executed by the player with manual inputs/decisions/confirmations from them after action initiation */
  case MANUAL = "Manual";
  
  /** Represents actions that can be executed automatically for a player without any inputs/decisions/confirmations from them after action initiation*/
  case AUTOMATIC = "Automatic";
}