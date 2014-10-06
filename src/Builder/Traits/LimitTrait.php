<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Clause\LimitClause;
use Packaged\QueryBuilder\Statement\StatementInterface;

trait LimitTrait
{
  public function limit($limit)
  {
    /**
     * @var $this StatementInterface
     */

    $limitClause = new LimitClause();
    $limitClause->setLimit($limit);
    $this->addClause($limitClause);
    return $this;
  }

  public function limitWithOffset($offset, $limit)
  {
    /**
     * @var $this StatementInterface
     */

    $limitClause = new LimitClause();
    $limitClause->setLimit($limit);
    $limitClause->setOffset($offset);
    $this->addClause($limitClause);
    return $this;
  }
}
