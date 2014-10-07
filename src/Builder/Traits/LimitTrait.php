<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\LimitClause;
use Packaged\QueryBuilder\Statement\IStatement;

trait LimitTrait
{
  public function limit($limit)
  {
    /**
     * @var $this IStatement
     */

    $limitClause = new LimitClause();
    $limitClause->setLimit($limit);
    $this->addClause($limitClause);
    return $this;
  }

  public function limitWithOffset($offset, $limit)
  {
    /**
     * @var $this IStatement
     */

    $limitClause = new LimitClause();
    $limitClause->setLimit($limit);
    $limitClause->setOffset($offset);
    $this->addClause($limitClause);
    return $this;
  }
}
