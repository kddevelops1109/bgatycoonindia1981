<?php
namespace Bga\Games\tycoonindianew\Type;

enum CardLocation: string {

  /** Basic locations */
  case HAND = "hand";
  case DECK = "deck";
  case CORPORATE_AGENDA_DECK = "corp-agenda-deck";
  case POLICY_DECK = "policy-deck";
  case INDUSTRY_DECK = "industry-deck";
  case MERIT_DECK = "merit-deck";
  case PLANNING_COMMISION_A_DECK = "pc-a-deck";
  case PLANNING_COMMISION_B_DECK = "pc-b-deck";
  case HEADLINE_DECK = "headline-deck";
  case DISCARDS = "discards";
  
  /** Preparation locations */
  case AGE_I_POLICIES_PREP = "age-1-policies";
  case AGE_II_POLICIES_PREP = "age-2-policies";
  case AGE_I_INDUSTRIES_PREP = "age-1-industries";
  case AGE_II_INDUSTRIES_PREP = "age-2-industries";
  case TYPE_A_PLANNING_COMMISSIONS_PREP = "pc-a-prep";
  case TYPE_B_PLANNING_COMMISSIONS_PREP = "pc-b-prep";
  case AGE_I_HEADLINES_PREP = "age-1-headlines";
  case AGE_II_HEADLINES_PREP = "age-2-headlines";

  /** Tableau locations */
  case POLICY_TABLEAU = "policy-tableau";
  case UNBUILT_INDUSTRY_TABLEAU = "unbuilt-tableau";
  case BUILT_INDUSTRY_TABLEAU = "built-tableau";

  /** Display locations */
  case POLICY_DISPLAY_1 = "policy-disp-1";
  case POLICY_DISPLAY_2 = "policy-disp-2";
  case INDUSTRY_DISPLAY_1 = "industry-disp-1";
  case INDUSTRY_DISPLAY_2 = "industry-disp-2";
  case INDUSTRY_DISPLAY_3 = "industry-disp-3";
  case MERIT_DISPLAY = "merit-disp";
  case PLANNING_COMMISSION_DISPLAY_A = "pc-disp-a";
  case PLANNING_COMMISSION_DISPLAY_B1 = "pc-disp-b1"; // Used if the Headline variant is not being played
  case PLANNING_COMMISSION_DISPLAY_B2 = "pc-disp-b2"; // Used if the Headline variant is not being played
  case PLANNING_COMMISSION_DISPLAY_B = "pc-disp-b"; // Used only if the Headline variant is being played, as there is only one Type B Planning Commission in play then
  case HEADLINE_DISPLAY = "headline-disp";
}