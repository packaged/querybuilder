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
}
