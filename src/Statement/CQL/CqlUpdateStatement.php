<?php
namespace Packaged\QueryBuilder\Statement\CQL;

use Packaged\QueryBuilder\Builder\Traits\CQL\UsingTrait;
use Packaged\QueryBuilder\Statement\UpdateStatement;

class CqlUpdateStatement extends UpdateStatement
{
  use UsingTrait;

  protected function _getOrder()
  {
    return ['UPDATE', 'USING', 'SET', 'WHERE', 'LIMIT'];
  }
}
