<?php
namespace Packaged\QueryBuilder\Expression;

class ValueExpression implements ExpressionInterface
{
  protected $_value;

  public function setValue($value)
  {
    $this->_value = $value;
    return $this;
  }

  public function getValue()
  {
    return $this->_value;
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    if($this->_value === null)
    {
      return 'NULL';
    }

    if(is_numeric($this->_value))
    {
      return $this->_value;
    }

    return '"' . $this->_value . '"';
  }

  public static function create($value)
  {
    $expression = new static;
    $expression->setValue($value);
    return $expression;
  }
}
