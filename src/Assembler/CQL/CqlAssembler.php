<?php
namespace Packaged\QueryBuilder\Assembler\CQL;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\CQL\AllowFilteringClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Predicate\BetweenPredicate;
use Packaged\QueryBuilder\Predicate\GreaterThanOrEqualPredicate;
use Packaged\QueryBuilder\Predicate\LessThanOrEqualPredicate;
use Packaged\QueryBuilder\Predicate\PredicateSet;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;

class CqlAssembler extends QueryAssembler
{
  public function assembleSegment($segment)
  {
    if($segment instanceof FieldExpression)
    {
      return $this->assembleField($segment);
    }
    else if($segment instanceof TableExpression)
    {
      return $this->assembleTableExpression($segment);
    }
    else if($segment instanceof AllowFilteringClause)
    {
      return 'ALLOW FILTERING';
    }
    else if($segment instanceof AllSelectExpression)
    {
      $segment->setTable(null);
    }
    else if($segment instanceof BetweenPredicate)
    {
      return $this->assembleBetween($segment);
    }
    else if($segment instanceof ValueExpression)
    {
      $assembler = new CqlExpressionAssembler($segment);
      return $assembler->assemble();
    }

    return parent::assembleSegment($segment);
  }

  public function assembleField(FieldExpression $field)
  {
    if($field->hasTable())
    {
      return $this->assembleTableExpression($field->getTable())
      . '."' . $field->getField() . '"';
    }
    else
    {
      return '"' . $field->getField() . '"';
    }
  }

  public function assembleTableExpression(TableExpression $expr)
  {
    return '"' . $expr->getTableName() . '"';
  }

  public function assembleBetween(BetweenPredicate $betweenPredicate)
  {
    $gte = new GreaterThanOrEqualPredicate();
    $gte->setField($betweenPredicate->getField());
    $gte->setExpression($betweenPredicate->getRangeStart());
    $lte = new LessThanOrEqualPredicate();
    $lte->setField($betweenPredicate->getField());
    $lte->setExpression($betweenPredicate->getRangeEnd());

    $set = new PredicateSet();
    $set->addPredicate($gte);
    $set->addPredicate($lte);
    return $this->assembleSegment($set);
  }
}
