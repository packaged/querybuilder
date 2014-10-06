<?php
namespace Packaged\QueryBuilder\Clause;

class HavingClause extends AbstractPredicateClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'HAVING';
  }

  public static function create(array $predicated)
  {
    $clause = new static;
    $clause->setPredicates(WhereClause::buildPredicates($predicated));
    return $clause;
  }
}
