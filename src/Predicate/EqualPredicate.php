<?php
namespace Packaged\QueryBuilder\Predicate;

class EqualPredicate extends AbstractOperatorPredicate
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return '=';
  }
}
