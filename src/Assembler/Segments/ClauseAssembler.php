<?php
namespace Packaged\QueryBuilder\Assembler\Segments;

use Packaged\QueryBuilder\Clause\AbstractFieldClause;
use Packaged\QueryBuilder\Clause\AbstractPredicateClause;
use Packaged\QueryBuilder\Clause\AbstractTableClause;
use Packaged\QueryBuilder\Clause\IClause;
use Packaged\QueryBuilder\Clause\InsertClause;
use Packaged\QueryBuilder\Clause\JoinClause;
use Packaged\QueryBuilder\Clause\LimitClause;
use Packaged\QueryBuilder\Clause\OrderByClause;
use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\Clause\ValuesClause;
use Packaged\QueryBuilder\Predicate\PredicateSet;

class ClauseAssembler extends AbstractSegmentAssembler
{
  public function __construct(IClause $clause)
  {
    $this->_segment = $clause;
  }

  public function assemble()
  {
    if($this->_segment instanceof ValuesClause)
    {
      return $this->assembleValuesClause($this->_segment);
    }
    else if($this->_segment instanceof SelectClause)
    {
      return $this->assembleSelectClause($this->_segment);
    }
    else if($this->_segment instanceof OrderByClause)
    {
      return $this->assembleOrderByClause($this->_segment);
    }
    else if($this->_segment instanceof LimitClause)
    {
      return $this->assembleLimitClause($this->_segment);
    }
    else if($this->_segment instanceof JoinClause)
    {
      return $this->assembleJoinClause($this->_segment);
    }
    else if($this->_segment instanceof InsertClause)
    {
      return $this->assembleInsertClause($this->_segment);
    }
    else if($this->_segment instanceof AbstractPredicateClause)
    {
      return $this->assemblePredicateClause($this->_segment);
    }
    else if($this->_segment instanceof AbstractTableClause)
    {
      return $this->assembleAbstractTableClause($this->_segment);
    }
    else if($this->_segment instanceof AbstractFieldClause)
    {
      return $this->assembleAbstractFieldClause($this->_segment);
    }

    return parent::assemble();
  }

  public function assembleJoinClause(JoinClause $clause)
  {
    return $clause->getAction() . ' ' . $clause->getTableName() . ' ON '
    . $this->assembleSegment($clause->getSource()) . ' = '
    . $this->assembleSegment($clause->getDestination())
    . ($clause->hasPredicates() ?
      ' AND ' .
      implode(
        $clause->getGlue(),
        $this->assembleSegments($clause->getPredicates())
      )
      : '');
  }

  public function assembleInsertClause(InsertClause $clause)
  {
    return $this->assembleAbstractTableClause($clause) . ' ('
    . implode(', ', $this->assembleSegments($clause->getFields()))
    . ')';
  }

  public function assembleLimitClause(LimitClause $clause)
  {
    return $clause->getAction() . ' '
    . ($clause->hasOffset() ? $clause->getOffset() . ',' : '')
    . $clause->getLimit();
  }

  public function assembleSelectClause(SelectClause $clause)
  {
    $return = $clause->getAction() . ($clause->isDistinct() ? ' DISTINCT' : '');

    if(!$clause->hasExpressions())
    {
      return $return . ' *';
    }

    return $return . ' '
    . implode(', ', $this->assembleSegments($clause->getExpressions()));
  }

  public function assembleAbstractTableClause(AbstractTableClause $clause)
  {
    return $clause->getAction() . ' ' . $clause->getTableName();
  }

  public function assembleValuesClause(ValuesClause $clause)
  {
    return $clause->getAction() . ' ('
    . implode(', ', $this->assembleSegments($clause->getExpressions()))
    . ')';
  }

  public function assembleOrderByClause(OrderByClause $clause)
  {
    $orders = [];
    foreach($clause->getFields() as $field)
    {
      $orders[] = trim(
        $field->getField() . ' '
        . strtoupper($clause->getOrder($field->getField(), ''))
      );
    }
    return $clause->getAction() . ' ' . implode(', ', $orders);
  }

  public function assembleAbstractFieldClause(AbstractFieldClause $clause)
  {
    return $clause->getAction() . ' '
    . implode(', ', $this->assembleSegments($clause->getFields()));
  }

  public function assemblePredicateClause(AbstractPredicateClause $clause)
  {
    if(count($clause->getPredicates()) === 1
      && head($clause->getPredicates()) instanceof PredicateSet
    )
    {
      return $clause->getAction() . ' '
      . substr(
        $this->getAssembler()->assembleSegment(head($clause->getPredicates())),
        1,
        -1
      );
    }
    else
    {
      return $clause->getAction() . ' '
      . implode(
        $clause->getGlue(),
        $this->assembleSegments($clause->getPredicates())
      );
    }
  }
}
