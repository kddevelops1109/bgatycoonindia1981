<?php
namespace Bga\Games\tycoonindianew\Type;

enum PolicyBenefitType: string {
  case IMMEDIATE = "Immediate Benefit";
  case PASSIVE = "Passive Benefit";
  case ENDGAME = "Endgame Bonus";
}