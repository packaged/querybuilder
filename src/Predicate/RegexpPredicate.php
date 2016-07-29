<?php
namespace Packaged\QueryBuilder\Predicate;

class RegexpPredicate extends AbstractOperatorPredicate
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return 'REGEXP';
  }
}
