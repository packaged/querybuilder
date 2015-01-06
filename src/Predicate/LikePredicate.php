<?php
namespace Packaged\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Expression\IExpression;
use Packaged\QueryBuilder\Expression\Like\CustomLikeExpression;

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

  public function setExpression(IExpression $value)
  {
    if(!($value instanceof CustomLikeExpression))
    {
      throw new \Exception('Invalid Expression Type');
    }
    $this->_value = $value;
    return $this;
  }
}
