<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\HavingClause;
use Packaged\QueryBuilder\Statement\IStatement;

trait HavingTrait
{
  public function having(...$expressions)
  {
    /**
     * @var $this IStatement
     */
    $where = HavingClause::create($expressions);
    $this->addClause($where);
    return $this;
  }
}
