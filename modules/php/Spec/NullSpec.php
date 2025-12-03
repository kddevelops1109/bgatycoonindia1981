<?php
namespace Bga\Games\tycoonindianew\Spec;

use Bga\Games\tycoonindianew\Contracts\Fungible;
use Bga\Games\tycoonindianew\Spec\Spec;
use Bga\Games\tycoonindianew\Type\SpecType;

class NullSpec implements Spec {

  private static ?NullSpec $instance = null;

  private function __construct() {
    // Private constructor just to create a NullCheck singleton instance
  }

  public static function get(): NullSpec {
    if (is_null(self::$instance)) {
      self::$instance = new NullSpec();
    }

    return self::$instance;
  }

  /**
   * Returns the fungibles associated with this spec, which is just an empty array, as this is a null spec
   * @return array<Fungible>
   */
  public function getFungibles(): array {
    return [];
  }


  /**
   * Gets the type of spec this represents, which is a null one in this case
   * @return SpecType
   */
  public function getType(): SpecType {
    return SpecType::NULL;
  }
}