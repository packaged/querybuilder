<?php
namespace Packaged\QueryBuilder\Assembler\CQL;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\CQL\AllowFilteringClause;
use Packaged\QueryBuilder\Clause\CQL\UsingClause;
use Packaged\QueryBuilder\Exceptions\Assembler\CqlAssemblerException;
use Packaged\QueryBuilder\Expression\AbstractArithmeticExpression;
use Packaged\QueryBuilder\Expression\CQL\ListExpression;
use Packaged\QueryBuilder\Expression\CQL\MapExpression;
use Packaged\QueryBuilder\Expression\CQL\MapFieldExpression;
use Packaged\QueryBuilder\Expression\CQL\SetExpression;
use Packaged\QueryBuilder\Predicate\BetweenPredicate;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Predicate\GreaterThanOrEqualPredicate;
use Packaged\QueryBuilder\Predicate\LessThanOrEqualPredicate;
use Packaged\QueryBuilder\Predicate\NotBetweenPredicate;
use Packaged\QueryBuilder\Predicate\NotEqualPredicate;
use Packaged\QueryBuilder\Predicate\PredicateSet;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;
use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;

class CqlAssembler extends QueryAssembler
{
  public function assembleSegment($segment)
  {
    if(($segment instanceof EqualPredicate || $segment instanceof NotEqualPredicate)
      && $segment->isNullValue()
    )
    {
      throw new CqlAssemblerException("Null is not available in CQL Queries");
    }

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
    else if($segment instanceof MapFieldExpression)
    {
      return $this->assembleMapFieldExpression($segment);
    }
    else if($segment instanceof ListExpression)
    {
      return $this->assembleListExpression($segment);
    }
    else if($segment instanceof MapExpression)
    {
      return $this->assembleMapExpression($segment);
    }
    else if($segment instanceof SetExpression)
    {
      return $this->assembleSetExpression($segment);
    }
    else if($segment instanceof AbstractArithmeticExpression)
    {
      return $this->assembleArithmeticExpression($segment);
    }

    return parent::assembleSegment($segment);
  }

  public function assembleArithmeticExpression(
    AbstractArithmeticExpression $expr
  )
  {
    $values = [];
    foreach($expr->getExpressions() as $value)
    {
      $values[] = $this->assembleSegment($value);
    }
    return implode(' ' . $expr->getOperator() . ' ', $values);
  }

  public function assembleMapExpression(MapExpression $map)
  {
    $return = [];
    $values = $this->assembleSegments((array)$map->getValue());
    foreach($values as $key => $value)
    {
      $return[] = "'$key':$value";
    }
    return '{' . implode(',', $return) . '}';
  }

  public function assembleSetExpression(SetExpression $set)
  {
    $prepared = $this->prepareParameter($set);
    if($prepared !== false)
    {
      return $prepared;
    }
    $values = $this->assembleSegments((array)$set->getValue());
    return '{' . implode(',', $values) . '}';
  }

  public function assembleListExpression(ListExpression $list)
  {
    $prepared = $this->prepareParameter($list);
    if($prepared !== false)
    {
      return $prepared;
    }
    $values = $this->assembleSegments((array)$list->getValue());
    return '[' . implode(',', $values) . ']';
  }

  public function assembleMapFieldExpression(MapFieldExpression $map)
  {
    $prepared = $this->prepareParameter($map);
    if($prepared !== false)
    {
      return $prepared;
    }
    $key = is_numeric($map->getKey())
      ? $map->getKey() : "'" . $map->getKey() . "'";
    return $map->getField() . '[' . $key . ']';
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
    $lte = new LessThanOrEqualPredicate();
    $lte->setField($betweenPredicate->getField());

    $set = new PredicateSet();
    if($betweenPredicate instanceof NotBetweenPredicate)
    {
      $gte->setExpression($betweenPredicate->getRangeEnd());
      $lte->setExpression($betweenPredicate->getRangeStart());
      $set->addPredicate($lte);
      $set->addPredicate($gte);
    }
    else
    {
      $gte->setExpression($betweenPredicate->getRangeStart());
      $lte->setExpression($betweenPredicate->getRangeEnd());
      $set->addPredicate($gte);
      $set->addPredicate($lte);
    }

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
