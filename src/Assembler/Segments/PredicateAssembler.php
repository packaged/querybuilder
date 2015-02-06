<?php
namespace Packaged\QueryBuilder\Assembler\Segments;

use Packaged\QueryBuilder\Predicate\AbstractOperatorPredicate;
use Packaged\QueryBuilder\Predicate\BetweenPredicate;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Predicate\IPredicate;
use Packaged\QueryBuilder\Predicate\NotEqualPredicate;
use Packaged\QueryBuilder\Predicate\PredicateSet;

class PredicateAssembler extends AbstractSegmentAssembler
{
  public function __construct(IPredicate $predicate)
  {
    $this->_segment = $predicate;
  }

  /**
   * Assemble the segment
   *
   * @return string
   */
  public function assemble()
  {
    if($this->_segment instanceof EqualPredicate)
    {
      return $this->assembleEqualPredicate($this->_segment);
    }
    if($this->_segment instanceof NotEqualPredicate)
    {
      return $this->assembleNotEqualPredicate($this->_segment);
    }
    else if($this->_segment instanceof PredicateSet)
    {
      return $this->assemblePredicateSet($this->_segment);
    }
    else if($this->_segment instanceof BetweenPredicate)
    {
      return $this->assembleBetweenPredicate($this->_segment);
    }
    else if($this->_segment instanceof AbstractOperatorPredicate)
    {
      return $this->assembleOperator($this->_segment);
    }

    return parent::assemble();
  }

  public function assembleBetweenPredicate(BetweenPredicate $predicate)
  {
    $assembler = $this->getAssembler();
    if($assembler->isForPrepare())
    {
      $start = $end = '?';
      $assembler->addParameter($predicate->getRangeStart());
      $assembler->addParameter($predicate->getRangeEnd());
    }
    else
    {
      $start = $this->assembleSegment($predicate->getRangeStart());
      $end = $this->assembleSegment($predicate->getRangeEnd());
    }

    return $this->assembleSegment($predicate->getField())
    . ' BETWEEN '
    . $start
    . ' AND '
    . $end;
  }

  public function assemblePredicateSet(PredicateSet $predicate)
  {
    if(!$predicate->hasPredicates())
    {
      return '';
    }

    return '(' . implode(
      $predicate->getGlue(),
      $this->assembleSegments($predicate->getPredicates())
    ) . ')';
  }

  public function assembleEqualPredicate(EqualPredicate $predicate)
  {
    if($predicate->isNullValue() && !$predicate->isOperatorForced())
    {
      return $this->assembleSegment($predicate->getField()) . ' IS NULL';
    }

    return $this->assembleOperator($predicate);
  }

  public function assembleNotEqualPredicate(NotEqualPredicate $predicate)
  {
    if($predicate->isNullValue())
    {
      return $this->assembleSegment($predicate->getField()) . ' IS NOT NULL';
    }

    return $this->assembleOperator($predicate);
  }

  public function assembleOperator(AbstractOperatorPredicate $predicate)
  {
    $assembler = $this->getAssembler();
    if($this->getAssembler()->isForPrepare())
    {
      $value = '?';
      $assembler->addParameter($predicate->getExpression());
    }
    else
    {
      $value = $this->assembleSegment($predicate->getExpression());
    }

    return implode(
      ' ',
      [
        $this->assembleSegment($predicate->getField()),
        $predicate->getOperator(),
        $value
      ]
    );
  }
}
