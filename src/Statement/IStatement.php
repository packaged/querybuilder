<?php
namespace Packaged\QueryBuilder\Statement;

use Packaged\QueryBuilder\Clause\IClause;

interface IStatement extends IStatementSegment
{
  public function addClause(IClause $clause);

  public function getClause($action);

  /**
   * @param $action
   *
   * @return bool
   */
  public function hasClause($action);

  /**
   * @param $action
   *
   * @return self
   */
  public function removeClause($action);

  /**
   * @return IStatementSegment[]
   */
  public function getSegments();
}
