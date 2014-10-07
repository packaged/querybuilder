<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\HavingClause;
use Packaged\QueryBuilder\Statement\IStatement;

trait HavingTrait
{
  public function having()
  {
    /**
     * @var $this IStatement
     */
    $where = HavingClause::create(func_get_args());
    $this->addClause($where);
    return $this;
  }
}
