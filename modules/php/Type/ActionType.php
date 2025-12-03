<?php
namespace Bga\Games\tycoonindianew\Type;

enum ActionType: string {
  case BUILD = "Build";
  case BUILD_DISCOUNTED = "Build (Discounted)";
  case POLITICS = "Politics";
  case MUSTER = "Muster";
  case STRATEGY = "Strategy";
  case STRATEGY_DISCOUNTED = "Strategy (Discounted)";
  case SHARE = "Share";
  case SHARE_DISCOUNTED = "Share (Discounted)";
  case LOAN = "Loan";
  case EMERGENCY_LOAN = "Emergency Loan";
  case CONGLOMERATE_BONUS = "Claim Conglomerate Bonus";
}