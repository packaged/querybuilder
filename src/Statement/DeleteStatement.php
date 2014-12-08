<?php
namespace Packaged\QueryBuilder\Statement;

use Packaged\QueryBuilder\Builder\Traits\WhereTrait;

class DeleteStatement extends AbstractStatement
{
  use WhereTrait;

  protected function _getOrder()
  {
    return ['DELETEFROM', 'WHERE'];
  }
}
