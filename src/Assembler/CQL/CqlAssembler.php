<?php
namespace Packaged\QueryBuilder\Assembler\CQL;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\CQL\AllowFilteringClause;
use Packaged\QueryBuilder\Clause\CQL\UsingClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Predicate\BetweenPredicate;
use Packaged\QueryBuilder\Predicate\GreaterThanOrEqualPredicate;
use Packaged\QueryBuilder\Predicate\LessThanOrEqualPredicate;
use Packaged\QueryBuilder\Predicate\PredicateSet;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;
use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;

class CqlAssembler extends QueryAssembler
{
  public function assembleSegment($segment)
  {
    if($segment instanceof FieldSelectExpression)
    {
      $segment->setAlias(null);
    }
    else if($segment instanceof PredicateSet)
    {
      return $this->assemblePredicateSet($segment);
    }
    else if($segment instanceof UsingClause)
    {
      return $this->assembleUsingClause($segment);
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

    return parent::assembleSegment($segment);
  }

  public function assembleUsingClause(UsingClause $clause)
  {
    $parts = [];
    if($clause->getTtl())
    {
      $parts[] = 'TTL ' . $this->assembleSegment($clause->getTtl());
    }
    if($clause->getTimestamp())
    {
      $parts[] = 'TIMESTAMP ' . $this->assembleSegment($clause->getTimestamp());
    }
    return $parts ? $clause->getAction() . ' ' . implode(' AND ', $parts) : '';
  }

  public function assemblePredicateSet(PredicateSet $predicate)
  {
    if(!$predicate->hasPredicates())
    {
      return '';
    }

    $predicates = $predicate->getPredicates();
    foreach($predicates as $p)
    {
      if($p instanceof PredicateSet)
      {
        throw new \Exception('Cannot have multiple predicate sets in CQL');
      }
    }

    return implode(
      $predicate->getGlue(),
      $this->assembleSegments($predicates)
    );
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

  public function escapeField($field)
  {
    return '"' . str_replace('"', '""', $field) . '"';
  }

  public function escapeValue($value)
  {
    return "'" . str_replace("'", "''", $value) . "'";
  }
}
