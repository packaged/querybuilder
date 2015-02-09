<?php
namespace Packaged\QueryBuilder\Statement;

use Packaged\QueryBuilder\Builder\Traits\InsertTrait;

class InsertStatement extends AbstractStatement
{
  use InsertTrait;

  protected function _getOrder()
  {
    return ['INSERTINTO', 'VALUES', 'ONDUPLICATEKEYUPDATE'];
  }
}
