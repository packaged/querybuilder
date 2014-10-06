<?php
namespace Packaged\QueryBuilder\Statement;

use Packaged\QueryBuilder\Builder\Traits\FromTrait;
use Packaged\QueryBuilder\Builder\Traits\GroupByTrait;
use Packaged\QueryBuilder\Builder\Traits\HavingTrait;
use Packaged\QueryBuilder\Builder\Traits\JoinTrait;
use Packaged\QueryBuilder\Builder\Traits\LimitTrait;
use Packaged\QueryBuilder\Builder\Traits\OrderByTrait;
use Packaged\QueryBuilder\Builder\Traits\WhereTrait;

class QueryStatement extends AbstractStatement
{
  use FromTrait;
  use JoinTrait;
  use WhereTrait;
  use GroupByTrait;
  use OrderByTrait;
  use LimitTrait;
  use HavingTrait;

  protected function _getOrder()
  {
    return [
      'SELECT',
      'FROM',
      'JOIN',
      'WHERE',
      'GROUPBY',
      'HAVING',
      'ORDERBY',
      'LIMIT'
    ];
  }
}
