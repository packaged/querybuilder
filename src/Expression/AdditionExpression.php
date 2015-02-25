<?php
namespace Packaged\QueryBuilder\Expression;

class AdditionExpression extends AbstractArithmeticExpression
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return '+';
  }
}
