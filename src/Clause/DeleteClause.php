<?php
namespace Packaged\QueryBuilder\Clause;

class DeleteClause extends AbstractTableClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'DELETE FROM';
  }
}
