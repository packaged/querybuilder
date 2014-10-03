<?php
namespace Packaged\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Expression\ExpressionInterface;
use Packaged\QueryBuilder\Expression\ValueExpression;

class BetweenPredicate implements PredicateInterface
{
  /**
   * @var ExpressionInterface
   */
  protected $_rangeStart;
  /**
   * @var ExpressionInterface
   */
  protected $_rangeEnd;
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

  public function setValues(
    ExpressionInterface $start, ExpressionInterface $end
  )
  {
    $this->_rangeStart = $start;
    $this->_rangeEnd   = $end;
    return $this;
  }

  public function getRangeStart()
  {
    return $this->_rangeStart ?: new ValueExpression();
  }

  public function getRangeEnd()
  {
    return $this->_rangeEnd ?: new ValueExpression();
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
    . $this->getRangeStart()->assemble()
    . ' AND '
    . $this->getRangeEnd()->assemble();
  }
}
