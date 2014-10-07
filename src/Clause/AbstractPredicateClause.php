<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Predicate\IPredicate;
use Packaged\QueryBuilder\Predicate\PredicateSet;

abstract class AbstractPredicateClause implements IClause
{
  protected $_predicates = [];

  public function addPredicate(IPredicate $predicate)
  {
    $this->_predicates[] = $predicate;
  }

  public function setPredicates(array $predicates)
  {
    $this->_predicates = assert_instances_of(
      $predicates,
      '\Packaged\QueryBuilder\Predicate\IPredicate'
    );
  }

  public function clearPredicates()
  {
    $this->_predicates = [];
  }

  public function getPredicates()
  {
    return $this->_predicates;
  }

  public function hasPredicates()
  {
    return !empty($this->_predicates);
  }

  public function getGlue()
  {
    return ' AND ';
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    if(count($this->_predicates) === 1
      && head($this->_predicates) instanceof PredicateSet
    )
    {
      return $this->getAction() . ' '
      . substr(head($this->_predicates)->assemble(), 1, -1);
    }
    else
    {
      return $this->getAction() . ' '
      . implode($this->getGlue(), mpull($this->getPredicates(), 'assemble'));
    }
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return false;
  }
}
