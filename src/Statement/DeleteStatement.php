<?php
namespace Packaged\QueryBuilder\Statement;

use Packaged\QueryBuilder\Builder\Traits\LimitTrait;
use Packaged\QueryBuilder\Builder\Traits\WhereTrait;

class DeleteStatement extends AbstractStatement
{
  use WhereTrait;
  use LimitTrait;

  protected function _getOrder()
  {
    return ['DELETEFROM', 'WHERE', 'LIMIT'];
  }
}
