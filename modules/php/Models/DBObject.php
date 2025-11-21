<?php
namespace Bga\Games\tycoonindianew\Models;

use BGA\Games\tycoonindianew\DB\Filter\DBFilter;
use Bga\Games\tycoonindianew\DB\Filter\SimpleDBFilter;
use Bga\Games\tycoonindianew\DB\Query\InsertDBQuery;
use Bga\Games\tycoonindianew\DB\Query\UpdateDBQuery;

use Bga\Games\tycoonindianew\Managers\DBManager;

use Bga\Games\tycoonindianew\Util\DataUtil;
use BgaVisibleSystemException;

abstract class DBObject implements \JsonSerializable {

  /**
   * Constants - Method calls
   */
  const METHOD_CALL_GET = "get";
  const METHOD_CALL_SET = "set";
  const METHOD_CALL_RESET = "reset";
  const METHOD_CALL_IS = "is";
  const METHOD_CALL_INC = "inc";
  const METHOD_CALL_DEC = "dec";

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
   * Construct this DB object from the associative array provided
   * @param array $arr
   */
  public function __construct($arr) {
    foreach ($this->dbFields as $field) {
      $fieldName = $field["name"];
      $fieldType = $field["type"];

      if ($arr[$fieldName] != null) {
        $this->$fieldName = DataUtil::getValue($arr[$fieldName], $fieldType);
      }
    }
  }

  /**
   * Return the value of the primary key for this db object
   */
  public function getPrimaryKeyFieldValue()
  {
    foreach ($this->dbFields as $field) {
      $fieldName = $field["name"];

      if ($fieldName == $this->primaryKey) {
        return $this->$fieldName;
      }
    }

    return null;
  }

  /**
   * Inserts this DB object in the database
   * @return void
   */
  public function insert() {
    $datas = [];
    foreach ($this->dbFields as $field) {
      $datas[] = [
        "column" => $field["column"],
        "type" => $field["type"],
        "value" => DataUtil::getValue($this->$field["name"], $field["type"])
      ];
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
    foreach ($this->dbFields as $_field) {
      if ($_field["name"] == $name) {
        $field = $_field;
        break;
      }
    }

    return $field;
  }

  private function getFieldType(string $name) {
    $type = null;
    foreach ($this->dbFields as $field) {
      if ($field["name"] == $name) {
        $type = $field["type"];
        break;
      }
    }

    return $type;
  }

  /**
   * Triggered when invoking inaccessible methods in an object context. This mainly handles getters, setters, is, increase and decrease method calls to db fields (properties).
   * @param mixed $method Name of the inaccessible method being called
   * @param mixed $args Arguments passed
   * @return void
   */
  public function __call($method, $args) {
    $methodCall = null;
    $fieldName = null;
    
    $field = [];

    // If the method contains one of the valid method calls, then update the same and parse the field name from the method
    foreach ([self::METHOD_CALL_GET, self::METHOD_CALL_SET, self::METHOD_CALL_RESET, self::METHOD_CALL_IS, self::METHOD_CALL_INC, self::METHOD_CALL_DEC] as $call) {
      if (str_starts_with($call, $method)) {
        $methodCall = $call;
        $fieldName = lcfirst(substr($method, strlen($call)));

        break;
      }
    }

    $validAccessibleMethod = false;

    // Find valid field in method, among db object's db and static fields, only if method call and field in method name were both found
    if ($methodCall != null && $fieldName != null) {
      foreach (array_merge($this->dbFields, $this->staticFields) as $_field) {
        if ($_field["name"] == $fieldName) {
          $field = $_field;
          break;
        }
      }
      
      // Proceed only if a valid field was found in the method
      if (isset($field) && !empty($field)) {
        $fieldType = strval($field["type"]);
        if ($fieldType == DataUtil::DATA_TYPE_BOOL["name"] && in_array($methodCall, [self::METHOD_CALL_RESET, self::METHOD_CALL_IS], true) ||
            $fieldType != DataUtil::DATA_TYPE_BOOL["name"] && $methodCall == self::METHOD_CALL_GET ||
            $fieldType == DataUtil::DATA_TYPE_INT["name"] && in_array($methodCall, [self::METHOD_CALL_INC, self::METHOD_CALL_DEC], true) ||
            $methodCall == self::METHOD_CALL_SET) {
          
          $validAccessibleMethod = true;
        }
      }
    }

    // If valid accessible method, then process it
    if ($validAccessibleMethod) {
      if ($methodCall == self::METHOD_CALL_GET) {
        return $this->getFieldValue($field["name"]);
      }
      else {
        $valueToSetInDb = null;
        if ($methodCall == self::METHOD_CALL_SET) {
          $key = null;

          if ($field["type"] == DataUtil::DATA_TYPE_OBJ["name"] && sizeof($args) > 1) {
            $key = $args[0];
            $value = DataUtil::getValue($args[1], $field["type"]);
          }
          else {
            $value = DataUtil::getValue($args[0], $field["type"]);
          }

          // Update only if value has not changed
          if ($value != null && $value != $this->getFieldValue($field["name"])) {
            $valueToSetInDb = $value;

            if ($field["type"] == DataUtil::DATA_TYPE_OBJ["name"]) {
              if ($key != null) {
                $this->$field["name"][$key] = $value;
              }
              else {
                $this->$field["name"] = json_encode($value);
              }
              
              $valueToSetInDb = addslashes(strval($this->$field["name"]));
            }
            elseif ($field["type"] == DataUtil::DATA_TYPE_STRING["name"]) {
              $this->$field["name"] = $value;
              $valueToSetInDb = addslashes($value);
            }
            elseif ($field["type"] == DataUtil::DATA_TYPE_BOOL["name"]) {
              if (boolval($value) == true) {
                $this->$field["name"] = 1;
                $valueToSetInDb = 1;
              }
              else {
                $this->$field["name"] = 0;
                $valueToSetInDb = 0;
              }
            }
            else {
              $this->$field["name"] = $value;
              $valueToSetInDb = $value;
            }
          }
        }
        elseif ($methodCall == self::METHOD_CALL_RESET) {
          $this->$field["name"] = 0;
        }
        elseif ($methodCall == self::METHOD_CALL_INC) {
          $amount = intval($args[0]);
          if ($amount > 0) {
            $currentValue = DataUtil::getValue($this->$field["name"], "int");
            $this->$field["name"] = $currentValue + $amount;
            $valueToSetInDb = $currentValue + $amount;
          }
        }
        elseif ($methodCall == self::METHOD_CALL_DEC) {
          $amount = intval($args[0]);
          if ($amount > 0) {
            $currentValue = DataUtil::getValue($this->$field["name"], "int");
            $this->$field["name"] = $currentValue - $amount;
            $valueToSetInDb = $currentValue - $amount;
          }
        }

        if ($valueToSetInDb != null) {
          $datas = [
            ["column" => $field["column"], "type" => $field["type"], "value" => $valueToSetInDb]
          ];
          $filter = new SimpleDBFilter($this->primaryKey["column"], $this->primaryKey["type"], SimpleDBFilter::OPERATOR_EQUALS, $this->$primaryKey["name"]);

          $query = new UpdateDBQuery($this->table, $datas, $filter);

          DBManager::execute($query);
        }
      }
    }
    else {
      // throw new BgaVisibleSystemException("Call to inaccessible method '" . $method . "'");
      return null;
    }
  }

  /**
   * Get value of given field for this db object
   * @param mixed $name
   */
  protected function getFieldValue($name) {
    $value = null;

    foreach ($this->dbFields as $field) {
      $fieldName = $field["name"];
      $fieldType = $field["type"];

      if ($fieldName == $name) {
        $value = DataUtil::getValue($this->$fieldName, $fieldType);
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
    foreach ($this->dbFields as $field) {
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
}