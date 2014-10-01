<?php
namespace Packaged\QueryBuilder\Predicate;

abstract class AbstractOperatorPredicate implements PredicateInterface
{
  protected $_field;
  protected $_value;

  /**
   * Operator e.g. =, >= >
   * @return string
   */
  abstract public function getOperator();

  public function setField($field)
  {
    $this->_field = $field;
    return $this;
  }

  public function getField()
  {
    return $this->_field;
  }

  public function setValue($value)
  {
    $this->_value = $value;
    return $this;
  }

  public function getValue()
  {
    return $this->_value;
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return $this->_field . ' ' . $this->getOperator() . ' '
    . (is_numeric($this->_value) ? $this->_value : "'$this->_value'");
  }
}
