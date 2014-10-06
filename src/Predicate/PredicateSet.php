<?php
namespace Packaged\QueryBuilder\Predicate;

class PredicateSet implements PredicateInterface
{
  protected $_predicates = [];

  public function addPredicate(PredicateInterface $predicate)
  {
    $this->_predicates[] = $predicate;
  }

  public function setPredicates(array $predicates)
  {
    $this->_predicates = assert_instances_of(
      $predicates,
      '\Packaged\QueryBuilder\Predicate\PredicateInterface'
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

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return '('
    . implode($this->getGlue(), mpull($this->getPredicates(), 'assemble'))
    . ')';
  }

  public function getGlue()
  {
    return ' AND ';
  }
}
