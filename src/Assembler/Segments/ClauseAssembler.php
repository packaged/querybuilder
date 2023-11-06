<?php
namespace Packaged\QueryBuilder\Assembler\Segments;

use Packaged\Helpers\Arrays;
use Packaged\Helpers\Strings;
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
  const MULTIPLE_VALUES = 'multiple_values';

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
    $segments = [];
    $source = $clause->getSource();
    $destination = $clause->getDestination();
    if($source !== null && $destination !== null)
    {
      $segments[] = $this->assembleSegment($source)
        . ' = ' . $this->assembleSegment($destination);
    }
    if($clause->hasPredicates())
    {
      $segments = array_merge(
        $segments,
        $this->assembleSegments($clause->getPredicates())
      );
    }
    return $clause->getAction() . ' '
      . $this->assembleSegment($clause->getTable())
      . ' ON ' . implode($clause->getGlue(), $segments);
  }

  public function assembleInsertClause(InsertClause $clause)
  {
    return $this->assembleAbstractTableClause($clause) . ' ('
      . implode(', ', $this->assembleSegments($clause->getFields()))
      . ')';
  }

  public function assembleLimitClause(LimitClause $clause)
  {
    $assembled = $clause->getAction() . ' ';
    if($clause->hasOffset())
    {
      $assembled .= $this->_assemblePrepared($clause->getOffset())
        ?: $clause->getOffset()->getValue();
      $assembled .= ',';
    }
    $assembled .= $this->_assemblePrepared($clause->getLimit())
      ?: $clause->getLimit()->getValue();
    return $assembled;
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
    return $clause->getAction() . ' '
      . $this->assembleSegment($clause->getTable());
  }

  public function assembleValuesClause(ValuesClause $clause)
  {
    $assembled = '('
      . implode(', ', $this->assembleSegments($clause->getExpressions()))
      . ')';

    $assembler = $this->getAssembler();
    if($assembler->getData(self::MULTIPLE_VALUES))
    {
      return $assembled;
    }
    $assembler->setData(self::MULTIPLE_VALUES, true);
    return $clause->getAction() . ' ' . $assembled;
  }

  public function assembleOrderByClause(OrderByClause $clause)
  {
    $orders = [];
    foreach($clause->getFields() as $field)
    {
      $orders[] = trim(
        $this->assembleSegment($field) . ' '
        . strtoupper($clause->getOrder($field, '') ?? '')
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
    if(!$clause->hasPredicates())
    {
      return '';
    }

    if(count($clause->getPredicates()) === 1
      && Arrays::first($clause->getPredicates()) instanceof PredicateSet
    )
    {
      $assembled = $this->getAssembler()->assembleSegment(
        Arrays::first($clause->getPredicates())
      );
      if(Strings::startsWith($assembled, '(')
        && Strings::endsWith($assembled, ')')
      )
      {
        $assembled = substr($assembled, 1, -1);
      }
      return $clause->getAction() . ' ' . $assembled;
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
