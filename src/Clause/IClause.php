<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Statement\IStatementSegment;

interface IClause extends IStatementSegment
{
  /**
   * @return string
   */
  public function getAction();

  /**
   * @return bool
   */
  public function allowMultiple();
}
