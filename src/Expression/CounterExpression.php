<?php
namespace Packaged\QueryBuilder\Expression;

abstract class CounterExpression implements IExpression
{
  protected $_field;
  protected $_table;
  protected $_value;
  protected $_defaultValue = 0;

  public function setValue($value)
  {
    $this->_value = is_scalar($value)
      ? NumericExpression::create($value) : $value;
    return $this;
  }

  public function getValue()
  {
    return $this->_value ?: ValueExpression::create($this->_defaultValue);
  }

  public function setField($field)
  {
    $this->_field = $field;
    return $this;
  }

  public function getField()
  {
    return $this->_field;
  }

  public static function create($field, $value = null)
  {
    $expression = new static;
    $expression->setField($field);
    $expression->setValue($value);
    return $expression;
  }

  /**
   * Operator e.g. +
   * @return string
   */
  abstract public function getOperator();
}
