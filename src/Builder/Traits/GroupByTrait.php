<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\GroupByClause;
use Packaged\QueryBuilder\Statement\IStatement;

trait GroupByTrait
{
  public function groupBy($fields)
  {
    /**
     * @var $this IStatement
     */
    $this->addClause(GroupByClause::create(...func_get_args()));
    return $this;
  }
}
