<?php
use Bga\Games\tycoonindianew\Type\Sector;

$classNames = [];
foreach(Sector::cases() AS $sector) {
  // Do not add Transport as it does not have an endgame sector favor token
  if ($sector != Sector::TRANSPORT) {
    $classNames[] = $sector->value . "EndgameSectorFavorToken";
  }
}