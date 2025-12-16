<?php
use Bga\Games\tycoonindianew\Type\CityName;

$classNames = [];
foreach (CityName::cases() as $cityName) {
  $classNames[] = str_replace(" ", "", $cityName->value);
}