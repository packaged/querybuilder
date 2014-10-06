<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Statement\StatementInterface;

trait FromTrait
{
  public function from($table)
  {
    /**
     * @var $this StatementInterface
     */

    $from = new FromClause();
    $from->setTableName($table);
    $this->addClause($from);
    return $this;
  }
}
