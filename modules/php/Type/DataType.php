<?php
namespace Bga\Games\tycoonindianew\Type;

enum DataType: string {
  case STRING = "string";
  case INT = "int";
  case BOOL = "bool";
  case OBJ = "obj";
  case PLAYER_COUNTER = "playerCounter";
  case TABLE_COUNTER = "tableCounter";
}