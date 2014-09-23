<?php
namespace Packaged\QueryBuilder\Clause;

class WhereClause extends AbstractPredicateClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'WHERE';
  }
}
