<?php
namespace Packaged\QueryBuilder\Predicate;

class NotEqualPredicate extends AbstractOperatorPredicate
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return '<>';
  }
}
