<?php
namespace Packaged\QueryBuilder\Expression;

class MultiplyExpression extends AbstractArithmeticExpression
{
  /**
   * Operator e.g. +
   * @return string
   */
  public function getOperator()
  {
    return '*';
  }
}
