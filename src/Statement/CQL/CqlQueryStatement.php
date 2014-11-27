<?php
namespace Packaged\QueryBuilder\Statement\CQL;

use Packaged\QueryBuilder\Statement\QueryStatement;

class CqlQueryStatement extends QueryStatement
{
  protected function _getOrder()
  {
    $order   = parent::_getOrder();
    $order[] = 'ALLOW_FILTERING';
    return $order;
  }
}
