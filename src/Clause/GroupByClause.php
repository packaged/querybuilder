<?php
namespace Packaged\QueryBuilder\Clause;

class GroupByClause extends AbstractFieldClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'GROUP BY';
  }
}
