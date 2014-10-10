<?php
namespace Packaged\QueryBuilder\Statement;

use Packaged\QueryBuilder\Clause\IClause;

interface IStatement extends IStatementSegment
{
  public function addClause(IClause $clause);

  public function getClause($action);

  /**
   * @return IStatementSegment[]
   */
  public function getSegments();
}
