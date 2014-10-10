<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Predicate\IPredicate;

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
   * @return bool
   */
  public function allowMultiple()
  {
    return false;
  }
}
