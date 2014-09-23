<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Predicate\PredicateInterface;

abstract class AbstractPredicateClause implements ClauseInterface
{
  protected $_predicates = [];

  public function addPredicate(PredicateInterface $predicate)
  {
    $this->_predicates[] = $predicate;
  }

  public function clearPredicates()
  {
    $this->_predicates = [];
  }
}
