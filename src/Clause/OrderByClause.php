<?php
namespace Packaged\QueryBuilder\Clause;

class OrderByClause implements ClauseInterface
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'ORDER BY';
  }
}
