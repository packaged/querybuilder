<?php
namespace Packaged\QueryBuilder\Statement;

use Packaged\QueryBuilder\Clause\ClauseInterface;

interface StatementInterface extends StatementSegmentInterface
{
  public function addClause(ClauseInterface $clause);

  public function getClause($action);
}
