<?php
namespace Packaged\QueryBuilder\Expression;

abstract class AbstractArithmeticExpression implements IExpression
{
  /**
   * @var IExpression[]
   */
  protected $_values = [];

  /**
   * Operator e.g. +
   * @return string
   */
  abstract public function getOperator();

  public function addExpression(IExpression $value)
  {
    $this->_values[] = $value;
    return $this;
  }

  public function getExpressions()
  {
    return $this->_values;
  }

  public static function create(...$values)
  {
    $expression = new static;
    foreach($values as $value)
    {
      if($value instanceof IExpression)
      {
        $expression->addExpression($value);
      }
      else
      {
        $expression->addExpression(ValueExpression::create($value));
      }
    }
    return $expression;
  }
}
