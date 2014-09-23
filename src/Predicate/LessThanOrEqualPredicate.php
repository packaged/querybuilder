<?php
namespace Packaged\QueryBuilder\Predicate;

class LessThanOrEqualPredicate extends AbstractOperatorPredicate
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return '<=';
  }
}
