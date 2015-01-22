<?php
namespace Packaged\QueryBuilder\Statement;

use Packaged\QueryBuilder\Builder\Traits\LimitTrait;
use Packaged\QueryBuilder\Builder\Traits\SetTrait;
use Packaged\QueryBuilder\Builder\Traits\UpdateTrait;
use Packaged\QueryBuilder\Builder\Traits\WhereTrait;

class UpdateStatement extends AbstractStatement
{
  use WhereTrait;
  use LimitTrait;
  use SetTrait;
  use UpdateTrait;

  protected function _getOrder()
  {
    return ['UPDATE', 'SET', 'WHERE', 'LIMIT'];
  }
}
