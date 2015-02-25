<?php
namespace Packaged\QueryBuilder\Expression;

class IncrementExpression extends CounterExpression
{
  public function setIncrementValue($increment = 1)
  {
    $this->setValue(NumericExpression::create($increment));
    return $this;
  }

  /**
   * Operator e.g. +
   * @return string
   */
  public function getOperator()
  {
    return '+';
  }
}
