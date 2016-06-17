<?php
namespace Packaged\QueryBuilder\Clause;

class LeftOuterJoinClause extends JoinClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'LEFT OUTER JOIN';
  }
}
