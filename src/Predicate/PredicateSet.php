<?php
namespace Packaged\QueryBuilder\Predicate;

class PredicateSet implements IPredicate
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
}
