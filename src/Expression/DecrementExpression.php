<?php
namespace Packaged\QueryBuilder\Expression;

class DecrementExpression extends CounterExpression
{
  public function setDecrementValue($decrement = 1)
  {
    $this->setValue(NumericExpression::create($decrement));
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
