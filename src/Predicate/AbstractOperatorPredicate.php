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

  public function __construct($field, $value = null)
  {
    $this->_field = $field;
    $this->_value = $value;
  }

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
}
