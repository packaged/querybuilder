<?php
namespace Packaged\QueryBuilder\Predicate;

class NotInPredicate extends AbstractOperatorPredicate
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return 'NOT IN';
  }
}
