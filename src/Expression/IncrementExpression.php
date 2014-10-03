<?php
namespace Packaged\QueryBuilder\Expression;

class IncrementExpression extends AbstractArithmeticExpression
{
  protected $_defaultValue = 0;

  public function setIncrementValue($increment = 1)
  {
    $this->setExpression(NumericExpression::create($increment));
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
