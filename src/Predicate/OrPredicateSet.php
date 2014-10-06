<?php
namespace Packaged\QueryBuilder\Predicate;

class OrPredicateSet extends PredicateSet
{
  public function getGlue()
  {
    return ' OR ';
  }
}
