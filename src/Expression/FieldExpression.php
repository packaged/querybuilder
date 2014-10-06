<?php
namespace Packaged\QueryBuilder\Expression;

class FieldExpression implements ExpressionInterface
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

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return (empty($this->_table) ? '' : $this->getTableName() . '.')
    . $this->getField();
  }

  public static function create($field, $table = null)
  {
    $expression = new static;
    $expression->setField($field);
    $expression->setTableName($table);
    return $expression;
  }
}
