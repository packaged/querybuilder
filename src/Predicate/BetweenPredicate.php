<?php
namespace Packaged\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\IExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;

class BetweenPredicate implements IPredicate
{
  /**
   * @var IExpression
   */
  protected $_rangeStart;
  /**
   * @var IExpression
   */
  protected $_rangeEnd;
  /**
   * @var FieldExpression
   */
  protected $_field;

  public function setField($field)
  {
    $this->_field = is_scalar($field) ?
      FieldExpression::create($field) : $field;
    return $this;
  }

  public function getField()
  {
    return $this->_field;
  }

  public function setValues(
    IExpression $start, IExpression $end
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
}
