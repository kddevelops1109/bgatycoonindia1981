<?php
namespace Bga\Games\tycoonindianew\Type;

enum StrategyActionType: string {

  case ADMINISTRATION = "Administration";
  case SALES = "Sales";
  case LOBBY = "Lobby";
  case OFFICE = "Office";
  case ADVERTISING = "Advertising";
  case EXPORT = "Export";
}