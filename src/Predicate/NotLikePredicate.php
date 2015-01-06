<?php
namespace Packaged\QueryBuilder\Predicate;

class NotLikePredicate extends LikePredicate
{
  public function getOperator()
  {
    return 'NOT LIKE';
  }
}
