<?php
namespace Packaged\QueryBuilder\Statement;

class DeleteStatement extends AbstractStatement
{
  protected function _getOrder()
  {
    return ['DELETEFROM', 'WHERE'];
  }
}
