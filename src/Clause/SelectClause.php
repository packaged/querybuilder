<?php
namespace Packaged\QueryBuilder\Clause;

class SelectClause extends AbstractPredicateClause
{
  public function getAction()
  {
    return 'SELECT';
  }
}
