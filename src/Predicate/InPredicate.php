<?php
namespace Packaged\QueryBuilder\Predicate;

class InPredicate extends AbstractOperatorPredicate
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return 'IN';
  }
}
