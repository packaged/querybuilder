<?php
namespace Packaged\QueryBuilder\Statement\CQL;

use Packaged\QueryBuilder\Builder\Traits\CQL\UsingTrait;
use Packaged\QueryBuilder\Statement\InsertStatement;

class CqlInsertStatement extends InsertStatement
{
  use UsingTrait;

  protected function _getOrder()
  {
    return ['INSERTINTO', 'VALUES', 'USING'];
  }
}
