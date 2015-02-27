<?php
namespace Packaged\QueryBuilder\Expression;

class IfExpression implements IExpression
{
  protected $_expression;
  protected $_trueValue;
  protected $_falseValue;

  public function setExpression($expression)
  {
    $this->_expression = $expression;
    return $this;
  }

  public function getExpression()
  {
    return $this->_expression;
  }

  public function setTrueValue($value)
  {
    $this->_trueValue = $value;
    return $this;
  }

  public function getTrueValue()
  {
    return $this->_trueValue instanceof ValueExpression
      ? $this->_trueValue : ValueExpression::create($this->_trueValue);
  }

  public function setFalseValue($value)
  {
    $this->_falseValue = $value;
    return $this;
  }

  public function getFalseValue()
  {
    return $this->_falseValue instanceof ValueExpression
      ? $this->_falseValue : ValueExpression::create($this->_falseValue);
  }

  public static function create($expression, $trueValue, $falseValue)
  {
    $expr = new static;
    $expr->setExpression($expression);
    $expr->setTrueValue($trueValue);
    $expr->setFalseValue($falseValue);
    return $expr;
  }
}
