<?php
namespace Packaged\QueryBuilder\Predicate;

class LikePredicate extends AbstractOperatorPredicate
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return 'LIKE';
  }
}
