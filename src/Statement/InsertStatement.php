<?php
namespace Packaged\QueryBuilder\Statement;

class InsertStatement extends AbstractStatement
{
  protected function _getOrder()
  {
    return ['INSERTINTO', 'VALUES'];
  }
}
