<?php
namespace Packaged\QueryBuilder\Statement;

class ReplaceStatement extends AbstractStatement
{
  protected function _getOrder()
  {
    return ['REPLACEINTO', 'VALUES'];
  }
}
