<?php
namespace Packaged\QueryBuilder\Expression;

class SubtractExpression extends AbstractArithmeticExpression
{
  /**
   * Operator e.g. +
   * @return string
   */
  public function getOperator()
  {
    return '-';
  }
}
