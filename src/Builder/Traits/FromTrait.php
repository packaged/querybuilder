<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Statement\IStatement;

trait FromTrait
{
  public function from($table)
  {
    /**
     * @var $this IStatement
     */

    $from = new FromClause();
    $from->setTableName($table);
    $this->addClause($from);
    return $this;
  }
}
