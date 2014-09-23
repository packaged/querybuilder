<?php
namespace Packaged\QueryBuilder\Clause;

class GroupByClause implements ClauseInterface
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'GROUP BY';
  }
}
