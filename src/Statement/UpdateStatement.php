<?php
namespace Packaged\QueryBuilder\Statement;

class UpdateStatement extends AbstractStatement
{
  protected function _getOrder()
  {
    return ['UPDATE', 'SET', 'WHERE'];
  }
}
