<?php
namespace Packaged\QueryBuilder\Clause;

class RightOuterJoinClause extends JoinClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'RIGHT OUTER JOIN';
  }
}
