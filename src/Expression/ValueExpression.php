<?php
namespace Packaged\QueryBuilder\Expression;

class ValueExpression implements IExpression
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

  public static function create($value)
  {
    $expression = new static;
    $expression->setValue($value);
    return $expression;
  }
}
