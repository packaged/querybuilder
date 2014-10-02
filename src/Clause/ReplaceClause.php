<?php
namespace Packaged\QueryBuilder\Clause;

class ReplaceClause extends InsertClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'REPLACE INTO';
  }
}
