<?php
namespace Packaged\QueryBuilder\Predicate;

class LikeBinaryPredicate extends LikePredicate
{
  /**
   * Operator e.g. =, >= >
   *
   * @return string
   */
  public function getOperator()
  {
    return 'LIKE BINARY';
  }
}
