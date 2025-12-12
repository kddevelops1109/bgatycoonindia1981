<?php
namespace Bga\Games\tycoonindianew\Type;

enum Ranking: string {
  case HIGHEST = "Highest";
  case SECOND_HIGHEST = "Second Highest";
  case LOWEST = "Lowest";
  case SECOND_LOWEST = "Second Lowest";
  case TOP_TWO = "Top Two";
}