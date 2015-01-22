<?php
namespace Packaged\QueryBuilder\Predicate;

class EqualPredicate extends AbstractOperatorPredicate
{
  protected $_forceOperator = false;

  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return '=';
  }

  public function forceOperator($forced = true)
  {
    $this->_forceOperator = $forced;
    return $this;
  }

  public function isOperatorForced()
  {
    return $this->_forceOperator;
  }
}
