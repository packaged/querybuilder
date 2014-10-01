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

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    if($this->_value === null)
    {
      return $this->_field . ' IS NOT NULL';
    }

    return parent::assemble();
  }
}
