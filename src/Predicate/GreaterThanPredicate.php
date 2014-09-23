<?php
namespace Packaged\QueryBuilder\Predicate;

class GreaterThanPredicate extends AbstractOperatorPredicate
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return '>';
  }
}
