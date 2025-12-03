<?php
namespace Bga\Games\tycoonindianew\Type;

use Bga\Games\tycoonindianew\Model\Card\Industry\IndustryCard;

enum CardType: string {
  case INDUSTRY = "Industry";
  case POLICY = "Policy";
  case MERIT = "Merit";
  case PLANNING_COMMISSION = "Planning Commission";
  case CORPORATE_AGENDA = "Corporate Agenda";
  case HEADLINE = "Headline";
  case PROMISSARY_NOTE = "Promissary Note";
}