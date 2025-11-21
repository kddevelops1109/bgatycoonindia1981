
-- ------
-- BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
-- tycoonindianew implementation : © <Your name here> <Your email address here>
-- 
-- This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
-- See http://en.boardgamearena.com/#!doc/Studio for more information.
-- -----

-- dbmodel.sql

-- This is the file where you are describing the database schema of your game
-- Basically, you just have to export from PhpMyAdmin your table structure and copy/paste
-- this export here.
-- Note that the database itself and the standard tables ("global", "stats", "gamelog" and "player") are
-- already created and must not be created here

-- Note: The database schema is created from this file when the game starts. If you modify this file,
--       you have to restart a game to see your changes in database.

-- Example 1: create a standard "card" table to be used with the "Deck" tools (see example game "hearts"):

-- CREATE TABLE IF NOT EXISTS `card` (
--   `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `card_type` varchar(16) NOT NULL,
--   `card_type_arg` int(11) NOT NULL,
--   `card_location` varchar(16) NOT NULL,
--   `card_location_arg` int(11) NOT NULL,
--   PRIMARY KEY (`card_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- Example 2: add a custom field to the standard "player" table
-- ALTER TABLE `player` ADD `player_my_custom_field` INT UNSIGNED NOT NULL DEFAULT '0';

ALTER TABLE `player` ADD `player_color_name` VARCHAR(16);
ALTER TABLE `player` ADD `player_is_tycoon` BIT(1) NOT NULL DEFAULT b'0';
ALTER TABLE `player` ADD `player_is_next_tycoon` BIT(1) NOT NULL DEFAULT b'0';
ALTER TABLE `player` ADD `player_influence` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_influence_rank` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_asset_value` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_favor` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_money` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_promoters_in_hand` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_promoters_in_pool` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_promissary_notes` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_loan_intake_level` INT UNSIGNED NOT NULL DEFAULT 30;
ALTER TABLE `player` ADD `player_finance` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_finance_rank` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_minerals` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_minerals_rank` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_fuel` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_fuel_rank` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_agro` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_agro_rank` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_power` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_power_rank` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_transport` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_transport_rank` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_actions_remaining` INT UNSIGNED NOT NULL DEFAULT 2;
ALTER TABLE `player` ADD `player_plus_one_actions_remaining` INT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `player` ADD `player_tycoon_actions_remaining` INT UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE `card` ADD `card_name` VARCHAR(100);
ALTER TABLE `card` ADD `card_promoters` INT UNSIGNED DEFAULT 0;

CREATE TABLE IF NOT EXISTS `tycoon_globals` (
  `name` varchar(50) NOT NULL,
  `value` int(10) unsigned NOT NULL,
  PRIMARY KEY(`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;