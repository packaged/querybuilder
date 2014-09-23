<?php
namespace Packaged\QueryBuilder\Clause;

class FromClause extends AbstractTableClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'FROM';
  }
}
