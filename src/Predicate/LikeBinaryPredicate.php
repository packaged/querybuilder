<?php
namespace Packaged\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Expression\IExpression;
use Packaged\QueryBuilder\Expression\Like\CustomLikeExpression;

class LikeBinaryPredicate extends LikePredicate
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return 'LIKE BINARY';
  }
}
