<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\UpdateClause;
use Packaged\QueryBuilder\Statement\IStatement;

trait UpdateTrait
{
  public function update($table)
  {
    /**
     * @var $this IStatement
     */

    $update = new UpdateClause();
    $update->setTable($table);
    $this->addClause($update);
    return $this;
  }
}
