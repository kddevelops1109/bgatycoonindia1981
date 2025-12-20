<?php
namespace Bga\Games\tycoonindianew\Type\Counters;

interface MaxValues {
  /** Max rank value (since max players = 4) */
  public const RANK = 4;

  /** Max loan intake level */
  public const LOAN_INTAKE_LEVEL = 60;

  /** Max number of promissary notes a player can gain */
  public const PROMISSARY_NOTES = 7;

  /** Max sector production level (for any sector) */
  public const SECTOR_LEVEL = 7;

  /** Max number of actions a player can take normally */
  public const ACTIONS = 2;

  /** Max number tycoon actions available */
  public const TYCOON_ACTIONS = 1;

  /** Max number of share tokens a player owns */
  public const SHARES_REMAINING = 9;

  /** Max number of unbuilt plants a player can have */
  public const UNBUILT_PLANTS = 9;

  /** Max number of plants a player can build */
  public const BUILT_PLANTS = 9;

  /** Max number of plants a player can build in a single region  */
  public const BUILT_PLANTS_IN_SINGLE_REGION = 8;
}