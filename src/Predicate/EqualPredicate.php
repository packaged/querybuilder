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

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    if($this->_value === null)
    {
      return $this->getField()->assemble() . ' IS NULL';
    }

    return parent::assemble();
  }
}
