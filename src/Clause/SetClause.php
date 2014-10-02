<?php
namespace Packaged\QueryBuilder\Clause;

class SetClause extends AbstractPredicateClause
{
  public function getAction()
  {
    return 'SET';
  }

  public function getGlue()
  {
    return ', ';
  }
}
