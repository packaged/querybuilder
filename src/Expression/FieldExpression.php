<?php
namespace Packaged\QueryBuilder\Expression;

class FieldExpression implements IExpression
{
  protected $_field;
  protected $_table;

  public function setField($field)
  {
    $this->_field = $field;
    return $this;
  }

  public function getField()
  {
    return $this->_field;
  }

  public function setTableName($table)
  {
    $this->_table = $table;
    return $this;
  }

  public function getTableName()
  {
    return $this->_table;
  }

  public function hasTableName()
  {
    return !empty($this->_table);
  }

  public static function create($field)
  {
    $expression = new static;
    $expression->setField($field);
    return $expression;
  }

  public static function createWithTable($field, $table)
  {
    $expression = new static;
    $expression->setField($field);
    $expression->setTableName($table);
    return $expression;
  }
}
