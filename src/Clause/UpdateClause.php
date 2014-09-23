<?php
namespace Packaged\QueryBuilder\Clause;

class UpdateClause extends AbstractTableClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'UPDATE';
  }
}
