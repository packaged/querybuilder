<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\HavingClause;
use Packaged\QueryBuilder\Statement\StatementInterface;

trait HavingTrait
{
  public function having()
  {
    /**
     * @var $this StatementInterface
     */
    $where = HavingClause::create(func_get_args());
    $this->addClause($where);
    return $this;
  }
}
