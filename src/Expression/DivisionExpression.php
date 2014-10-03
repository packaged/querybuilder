<?php
namespace Packaged\QueryBuilder\Expression;

class DivisionExpression extends AbstractArithmeticExpression
{
  /**
   * Operator e.g. +
   * @return string
   */
  public function getOperator()
  {
    return '/';
  }
}
