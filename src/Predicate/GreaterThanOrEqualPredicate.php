<?php
namespace Packaged\QueryBuilder\Predicate;

class GreaterThanOrEqualPredicate extends AbstractOperatorPredicate
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return '>=';
  }
}
