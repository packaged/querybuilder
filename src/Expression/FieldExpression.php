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

  public function setTable($table)
  {
    if($table instanceof TableExpression)
    {
      $this->_table = $table;
    }
    else if($table !== null)
    {
      $this->_table = TableExpression::create($table);
    }
    return $this;
  }

  public function getTable()
  {
    return $this->_table;
  }

  public function hasTable()
  {
    return $this->_table !== null;
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
    $expression->setTable($table);
    return $expression;
  }
}
