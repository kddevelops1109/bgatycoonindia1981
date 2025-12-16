<?php
namespace Bga\Games\tycoonindianew\Type;

enum CityName: string {
  /** North cities */
  case UDAIPUR = "Udaipur";
  case JAIPUR = "Jaipur";
  case NEW_DELHI = "New Delhi";
  case LUDHIANA = "Ludhiana";
  case BHAKRA_NANGAL = "Bhakra Nangal";
  case KANPUR = "Kanpur";
  case LUCKNOW = "Lucknow";
  case BENARES = "Benares";

  /** East cities */
  case DURGAPUR = "Durgapur";
  case DIBRUGARH = "Dibrugarh";
  case CALCUTTA = "Calcutta";
  case BOKARO = "Bokaro";
  case JAMSHEDPUR = "Jamshedpur";
  case ROURKELA = "Rourkela";
  case HIRAKUD = "Hirakud";
  case BHILAI = "Bhilai";

  /** West cities */
  case KUTCH = "Kutch";
  case JAMNAGAR = "Jamnagar";
  case SURAT = "Surat";
  case INDORE = "Indore";
  case NASHIK = "Nashik";
  case BOMBAY = "Bombay";
  case POONA = "Poona";
  case KOHLAPUR = "Kohlapur";

  /** South cities */
  case MARGAO = "Margao";
  case BANGALORE = "Bangalore";
  case MYSORE = "Mysore";
  case COCHIN = "Cochin";
  case COIMBATORE = "Coimbatore";
  case MADRAS = "Madras";
  case HYDERABAD = "Hyderabad";
  case VISHAKAPATNAM = "Vishakapatnam";
}