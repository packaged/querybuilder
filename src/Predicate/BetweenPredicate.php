<?php
namespace Packaged\QueryBuilder\Predicate;

class BetweenPredicate implements PredicateInterface
{
  protected $_rangeStart;
  protected $_rangeEnd;

  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return 'BETWEEN';
  }

  public function __construct($field, $start = null, $end = null)
  {
    $this->_field      = $field;
    $this->_rangeStart = $start;
    $this->_rangeEnd   = $end;
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

  public function setValues($start, $end)
  {
    $this->_rangeStart = $start;
    $this->_rangeEnd   = $end;
    return $this;
  }

  public function getRangeStart()
  {
    return $this->_rangeStart;
  }

  public function getRangeEnd()
  {
    return $this->_rangeEnd;
  }

  public function getRangeValues()
  {
    return [$this->_rangeStart, $this->_rangeEnd];
  }
}
