<?php
namespace Packaged\QueryBuilder\Predicate;

class LessThanPredicate extends AbstractOperatorPredicate
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return '<';
  }
}
