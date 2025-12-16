<?php
namespace Bga\Games\tycoonindianew\Model;

use Bga\GameFramework\Components\Counters\PlayerCounter;
use Bga\GameFramework\Components\Counters\TableCounter;
use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;
use Bga\Games\tycoonindianew\Game;

use Bga\Games\tycoonindianew\Filter\DBFilter;
use Bga\Games\tycoonindianew\Filter\SimpleDBFilter;

use Bga\Games\tycoonindianew\Query\InsertDBQuery;
use Bga\Games\tycoonindianew\Query\UpdateDBQuery;

use Bga\Games\tycoonindianew\Manager\DBManager;
use Bga\Games\tycoonindianew\Query\SelectDBQuery;
use Bga\Games\tycoonindianew\Registry\EffectRegistry;
use Bga\Games\tycoonindianew\Type\DataType as DT;
use Bga\Games\tycoonindianew\Type\OperatorType;

use Bga\Games\tycoonindianew\Util\DataUtil;

#[\AllowDynamicProperties]
abstract class DBObject implements \JsonSerializable {

  /**
   * Table that this DB object represents
   * @var string
   */
  protected $table = null;

  /**
   * Name, type and column of field that is the primary key of this DB object's table
   * @var array
   */
  protected $primaryKey = null;

  /**
   * List of field names, their columns and their types linking class attributes to the DB fields
   * @var array
   */
  protected $dbFields = [];

  /**
   * List of static field names for this db object, not stored in the database, and are not dynamic
   * @var array
   */
  protected $staticFields = [];

  /**
   * DB field mappings common to all db objects
   * @return array
   */
  public static function dbFieldMappings(): array {
    return [];
  }

  /**
   * Static fields list common to all DB objects, if any
   * @return array
   */
  public static function staticFieldsList(): array {
    return [];
  }

  /**
   * Static field args common to all DB objects, if any
   * @return array
   */
  public static function staticFieldArgs(): array {
    return [];
  }

  /**
   * Returns db object corresponding to this filter
   * @param DBFilter $filter
   * @return static|null
   */
  public static function fromDb(DBFilter $filter): static|null {
    $query = new SelectDBQuery(static::TABLE_NAME, array_keys(static::dbFieldMappings()), $filter, null, null, 1, true, true);
    $queryResult = DBManager::execute($query);

    if (!is_null($queryResult) && $queryResult->isSuccessful()) {
      $args = $queryResult->getResult();
      return new static($args);
    }

    return null;
  }

  /**
   * Construct this DB object from the associative array provided
   * @param array $args
   */
  public function __construct($args) {
    $this->table = static::TABLE_NAME;
    $this->dbFields = static::dbFieldMappings();
    $this->staticFields = static::staticFieldsList();

    // Update static fields
    foreach ($this->staticFields as $fieldName) {
      if (array_key_exists($fieldName, $args)) {
        $this->$fieldName = $args[$fieldName];
      }
    }

    // Update db fields
    foreach ($this->dbFields as $column => $field) {
      $fieldName = $field["name"];
      $fieldType = $field["type"];

       if (array_key_exists($fieldName, $args)) {
        if ($fieldType == DT::PLAYER_COUNTER) {
          $value = Game::get()->counterFactory->createPlayerCounter($column);
        }
        elseif ($fieldType == DT::TABLE_COUNTER) {
          $value = Game::get()->counterFactory->createTableCounter($column);
        }
        elseif ($fieldType == DT::OBJ) {
          $value = $args[$fieldName];
        }
        else {
          $value = DataUtil::getValue($args[$fieldName], $fieldType);
        }

        $this->$fieldName = $value;
      }
    }
  }

  /**
   * Return the value of the primary key for this db object
   */
  public function getPrimaryKeyFieldValue()
  {
    $primaryKeyFieldName = $this->primaryKey["name"];
    return $this->$primaryKeyFieldName;
  }

  /**
   * Inserts this DB object in the database
   * @return void
   */
  public function insert() {
    $datas = [];
    foreach ($this->dbFields as $column => $field) {
      $fieldName = $field["name"];
      $fieldType = $field["type"];

      if (isset($this->$fieldName)) {
        $datas[] = [
          "column" => $column,
          "type" => $field["type"],
          "value" => DataUtil::getValue($this->$fieldName, $fieldType)
        ];
      }
    }

    DBManager::execute(new InsertDBQuery($this->table, $datas));
  }

  /**
   * Update the given column values for this db object
   * @param array $data
   * @param DBFilter $filter
   * @return void
   */
  public function update(array $data, DBFilter $filter) {
    $datas = [];
    foreach ($data as $fieldName => $value) {
      $field = $this->getDbFieldByName($fieldName);
      $readOnly = boolval($field["readOnly"]);

      if (!$readOnly) {
        $datas[] = [
          "column" => $field["column"],
          "type" => $field["type"],
          "value" => DataUtil::getValue($value, $field["type"])
        ];
      }
    }

    DBManager::execute(new UpdateDBQuery($this->table, $datas, $filter));
  }

  private function getDbFieldByName(string $name) {
    $field = null;
    foreach ($this->dbFields as $column => $_field) {
      if ($_field["name"] == $name) {
        $field = $_field;
        break;
      }
    }

    return $field;
  }

  private function getDbFieldType(string $name): string {
    return $this->getDbFieldByName($name)["type"];
  }

  private function getDbFieldByColumn(string $column) {
    return $this->dbFields[$column];
  }

  /**
   * Triggered when invoking inaccessible methods in an object context. This mainly handles getters, setters, is, increase and decrease method calls to db fields (properties).
   * @param mixed $method Name of the inaccessible method being called
   * @param mixed $args Arguments passed
   * @return void
   */
  public function __call($method, $args) {
    $methodFieldResult = $this->determineFieldNameAndMethodCallFromMethod($method);
    
    $methodCall = $methodFieldResult["methodCall"];
    $fieldName = $methodFieldResult["fieldName"];

    $field = $this->getFieldFromFieldName($fieldName);
    
    // Proceed only if a valid field was found in the method
    if (isset($field) && !empty($field)) {
      $fieldType = $field["type"];

      if ($methodCall == self::METHOD_CALL_GET) {
        return $this->getValue($field, $args);
      }
      elseif ($methodCall == self::METHOD_CALL_SET) {
        $this->setValue($field, $args);
      }
      elseif (in_array($methodCall, [self::METHOD_CALL_INC, self:: METHOD_CALL_DEC]) && in_array($fieldType, [DT::INT, DT::PLAYER_COUNTER, DT::TABLE_COUNTER])) {
        $methodCall == self::METHOD_CALL_INC ? $this->incValue($field, $args) : $this->decValue($field, $args);
      }
      elseif ($methodCall == self::METHOD_CALL_IS) {
        return $this->isValue($field);
      }
      elseif ($methodCall == self::METHOD_CALL_RESET) {
        $this->resetValue($field);
      }
    }
  }

  private function getValue($field, $args): mixed {
    $fieldName = strval($field["name"]);
    $fieldType = strval($field["type"]);

    $value = null;

    if ($fieldType == DT::OBJ) {
      $jsonValue = DataUtil::getValue($this->$fieldName, $fieldType);
      if (!empty($args)) {
        $value = json_decode($jsonValue, true);
        if (array_key_exists($args[0], $value)) {
          $value = $value[$args[0]];
        }
      }
      else {
        $value = json_decode($jsonValue, true);
      }
    }
    else {
      $value = DataUtil::getValue($this->$fieldName, $fieldType);
    }

    return $value;
  }

  private function setValue($field, $args) {
    $fieldName = strval($field["name"]);
    $fieldType = strval($field["type"]);

    $value = null;

    if ($fieldType == DT::OBJ) {
      if (sizeof($args) > 1) {
        $key = $args[0];
        $value = $args[1];

        $decoded_json = json_decode($this->$fieldName, true);
        $decoded_json[$key] = $value;

        // Encode and update
        $this->$fieldName = json_encode($decoded_json);
      }
      else {
        $value = $args[0];
        if (is_string($value)) {
          $this->$fieldName = $value;
        }
        elseif (is_array($value)) {
          $this->$fieldName = json_encode($value);
        }
      }
    }
    elseif (in_array($fieldType, [DT::PLAYER_COUNTER, DT::TABLE_COUNTER])) {
      $counter = $this->$fieldName;
      $value = DataUtil::getValue($args[0], DT::INT);

      if ($counter instanceof PlayerCounter) {
        $player_id = intval($args[1]);
        $counter->set($player_id, $value);
      }
      elseif ($counter instanceof TableCounter) {
        $counter->set($value);
      }
    }
    else {
      $value = DataUtil::getValue($args[0], $fieldType);
      $this->$fieldName = $value;
    }

    if ($value != null) {
      // Update value in DB
      $id_field = Industrialist::FIELD_PLAYER_ID;
      $filter = new SimpleDBFilter(Industrialist::COLUMN_PLAYER_ID, DT::INT, OperatorType::EQUALS, $this->$id_field);

      $this->update([$fieldName => $value], $filter);
    }
  }

  private function incValue($field, $args) {
    $fieldName = strval($field["name"]);
    $fieldType = strval($field["type"]);

    $value = null;

    if ($fieldType == DT::INT) {
      $value = DataUtil::getValue($this->$fieldName, $fieldType);

      if (!empty($args)) {
        $this->$fieldName = $value + DataUtil::getValue($args[0], DT::INT);
      }
      else {
        $this->$fieldName = $value + 1;
      }
    }
    else {
      $counter = $this->$fieldName;
      if ($counter instanceof PlayerCounter) {
        $player_id = DataUtil::getValue($args[0], DT::INT);
        
        $value = 1;
        if (sizeof($args) > 2) {
          $value = DataUtil::getValue($args[1], DT::INT);
        }
        
        $counter->inc($player_id, $value);
      }
      elseif ($counter instanceof TableCounter) {
        $value = 1;
        if (!empty($args)) {
          $value = DataUtil::getValue($args[0], DT::INT);
        }

        $counter->inc($value);
      }
    }

    // Update value in DB
    if ($value != null) {
      $id_field = Industrialist::FIELD_PLAYER_ID;
      $filter = new SimpleDBFilter(Industrialist::COLUMN_PLAYER_ID, DT::INT, OperatorType::EQUALS, $this->$id_field);

      $this->update([$fieldName => $value], $filter);
    }
  }

  private function decValue($field, $args) {
    $fieldName = strval($field["name"]);
    $fieldType = strval($field["type"]);

    $value = null;

    if ($fieldType == DT::INT) {
      $value = DataUtil::getValue($this->$fieldName, $fieldType);

      if (!empty($args)) {
        $this->$fieldName = $value - DataUtil::getValue($args[0], DT::INT);
      }
      else {
        $this->$fieldName = $value - 1;
      }
    }
    else {
      $counter = $this->$fieldName;
      if ($counter instanceof PlayerCounter) {
        $player_id = DataUtil::getValue($args[0], DT::INT);
        
        $value = 1;
        if (sizeof($args) > 2) {
          $value = DataUtil::getValue($args[1], DT::INT);
        }
        
        $counter->inc($player_id, (0 - $value));
      }
      elseif ($counter instanceof TableCounter) {
        $value = 1;
        if (!empty($args)) {
          $value = DataUtil::getValue($args[0], DT::INT);
        }

        $counter->inc((0 - $value));
      }
    }

    // Update value in DB
    if ($value != null) {
      $id_field = Industrialist::FIELD_PLAYER_ID;
      $filter = new SimpleDBFilter(Industrialist::COLUMN_PLAYER_ID, DT::INT, OperatorType::EQUALS, $this->$id_field);

      $this->update([$fieldName => $value], $filter);
    }
  }

  private function isValue($field) {
    $fieldName = strval($field["name"]);
    $fieldType = strval($field["type"]);

    if ($fieldType == DT::BOOL) {
      return DataUtil::getValue($this->$fieldName, $fieldType);
    }
    else {
      return null;
    }
  }

  private function resetValue($field) {
    $fieldName = strval($field["name"]);
    $fieldType = strval($field["type"]);

    if ($fieldType == DT::BOOL) {
      $this->$fieldName = false;
    }

    // Update value in DB
    $id_field = Industrialist::FIELD_PLAYER_ID;
    $filter = new SimpleDBFilter(Industrialist::COLUMN_PLAYER_ID, DT::INT, OperatorType::EQUALS, $this->$id_field);

    $this->update([$fieldName => 0], $filter);
  }

  private function determineFieldNameAndMethodCallFromMethod($method) {
    $result = ["methodCall" => null, "fieldName" => null];

    // If the method contains one of the valid method calls, then update the same and parse the field name from the method
    foreach ([self::METHOD_CALL_GET, self::METHOD_CALL_SET, self::METHOD_CALL_RESET, self::METHOD_CALL_IS, self::METHOD_CALL_INC, self::METHOD_CALL_DEC] as $call) {
      if (str_starts_with($call, $method)) {
        $result["methodCall"] = $call;
        $result["fieldName"] = lcfirst(substr($method, strlen($call)));

        break;
      }
    }

    return $result;
  }

  private function getFieldFromFieldName($fieldName) {
    $field = [];

    // Find valid field in method
    if ($fieldName != null) {
      foreach (array_merge(array_values($this->dbFields), $this->staticFields) as $_field) {
        if ($_field["name"] == $fieldName) {
          $field = $_field;
          break;
        }
      }
    }

    return $field;
  }

  /**
   * Get value of given field for this db object
   * @param mixed $name
   */
  protected function getFieldValue($name) {
    $value = null;

    foreach ($this->dbFields as $column => $field) {
      $fieldName = $field["name"];
      $fieldType = $field["type"];

      if ($fieldName == $name) {
        if (in_array($fieldType, [DT::PLAYER_COUNTER, DT::TABLE_COUNTER])) {
          $value = $this->$fieldName;
        }
        else {
          $value = DataUtil::getValue($this->$fieldName, $fieldType);
        }

        break;
      }
    }

    return $value;
  }

  public function jsonSerialize(): mixed {
    return $this->getDbData();
  }

  /**
   * Returns an associative array representing the db fields and their values for this db object
   * @return array
   */
  public function getDbData(): array {
    $data = [];
    foreach ($this->dbFields as $column => $field) {
      $fieldName = $field["name"];
      
      $data[$fieldName] = $this->getFieldValue($fieldName);
    }

    return $data;
  }

  /**
   * Returns an associative array representing the static fields and their values for this db object
   * @return array
   */
  public function getStaticData(): array {
    $data = [];
    foreach ($this->staticFields as $field) {
      $fieldName = $field["name"];
      
      $data[$fieldName] = $this->getFieldValue($fieldName);
    }

    return $data;
  }

  /**
   * Returns an array that is a merge of the two associative arrays for this db object, the db data and the static data
   * @return array
   */
  public function getData() {
    return array_merge($this->getDbData(), $this->getStaticData());
  }

  /**
   * Assign given effect to the db object, based on provided args.
   * Args are expected to have the following:
   * - Name of effect field
   * - Type (Effect type)
   * - Gain/Loss
   * - Fungible type
   * - Amount
   * - Multiplier
   * - Condition, if any
   * - Spec, if any
   * - Trigger, if any
   * - Round down
   * @param array $args
   * @return void
   */
  protected function assignEffect(array $args): void {
    $fieldName = $args["fieldName"];
    $this->$fieldName = EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Evaluate and apply the given effect for this db object
   * @param string $playerId ID of the player to apply effect to
   * @param string $fieldName Name of the effect field
   * @return void
   */
  protected function applyEffect(int $playerId, string $fieldName): void {
    $effect = $this->$fieldName;
    if ($effect instanceof Effect) {
      $effect->apply($playerId);
    }
  }

  /**
   * Evaluate the given effect for this db object, but do not apply it, just return it to serve the purpose of a review
   * @param int $playerId
   * @param string $fieldName
   * @return int
   */
  protected function previewEffect(int $playerId, string $fieldName): int {
    $effect = $this->$fieldName;
    if ($effect instanceof Effect) {
      return $effect->preview($playerId);
    }

    return 0;
  }

  /**
   * Constants - Method calls
   */
  const METHOD_CALL_GET = "get";
  const METHOD_CALL_SET = "set";
  const METHOD_CALL_RESET = "reset";
  const METHOD_CALL_IS = "is";
  const METHOD_CALL_INC = "inc";
  const METHOD_CALL_DEC = "dec";
}