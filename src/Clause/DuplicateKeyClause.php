<?php
namespace Packaged\QueryBuilder\Clause;

class DuplicateKeyClause extends AbstractPredicateClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'ON DUPLICATE KEY UPDATE';
  }

  public function getGlue()
  {
    return ', ';
  }
}
