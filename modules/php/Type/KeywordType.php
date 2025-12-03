<?php
namespace Bga\Games\tycoonindianew\Type;

enum KeywordType: string {
  case INTO = 'INTO';
  case VALUES = 'VALUES';
  case FROM = 'FROM';
  case WHERE = 'WHERE';
  case SET = 'SET';
  case ORDER_BY = 'ORDER BY';
  case LIMIT = 'LIMIT';
}