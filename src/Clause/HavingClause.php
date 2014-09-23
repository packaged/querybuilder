<?php
namespace Packaged\QueryBuilder\Clause;

class HavingClause implements ClauseInterface
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'HAVING';
  }
}
