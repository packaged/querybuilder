<?php
namespace Packaged\QueryBuilder\Clause\CQL;

use Packaged\QueryBuilder\Clause\IClause;

class AllowFilteringClause implements IClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'ALLOW_FILTERING';
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return false;
  }
}
