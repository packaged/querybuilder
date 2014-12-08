<?php
namespace Packaged\QueryBuilder\Statement;

use Packaged\QueryBuilder\Builder\Traits\WhereTrait;

class UpdateStatement extends AbstractStatement
{
  use WhereTrait;

  protected function _getOrder()
  {
    return ['UPDATE', 'SET', 'WHERE'];
  }
}
