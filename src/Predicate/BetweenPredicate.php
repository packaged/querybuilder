<?php
namespace Packaged\QueryBuilder\Predicate;

class BetweenPredicate implements PredicateInterface
{
  protected $_rangeStart = 0;
  protected $_rangeEnd = 0;
  protected $_field;

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

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return $this->_field . ' BETWEEN '
    . (is_numeric($this->_rangeStart)
      ? $this->_rangeStart : "'$this->_rangeStart'")
    . ' AND '
    . (is_numeric($this->_rangeEnd) ? $this->_rangeEnd : "'$this->_rangeEnd'");
  }
}
