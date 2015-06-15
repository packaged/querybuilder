<?php
namespace Packaged\QueryBuilder\Predicate;

use Packaged\Helpers\Arrays;

class PredicateSet implements IPredicate
{
  protected $_predicates = [];

  public function addPredicate(IPredicate $predicate)
  {
    $this->_predicates[] = $predicate;
  }

  public function setPredicates(array $predicates)
  {
    $this->_predicates = Arrays::instancesOf(
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

  public static function create(...$predicates)
  {
    $predicate = new static;
    $predicate->setPredicates($predicates);
    return $predicate;
  }
}
