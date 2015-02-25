<?php
namespace Packaged\QueryBuilder\Expression;

class DecrementExpression extends SubtractExpression
{
  protected $_defaultValue = 0;

  public function setDecrementValue($decrement = 1)
  {
    $this->setExpression(NumericExpression::create($decrement));
    return $this;
  }

  /**
   * Operator e.g. +
   * @return string
   */
  public function getOperator()
  {
    return '-';
  }
}
