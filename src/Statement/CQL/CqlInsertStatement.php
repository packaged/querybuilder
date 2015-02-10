<?php
namespace Packaged\QueryBuilder\Statement\CQL;

use Packaged\QueryBuilder\Clause\CQL\TtlClause;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Statement\InsertStatement;

class CqlInsertStatement extends InsertStatement
{
  protected function _getOrder()
  {
    return ['INSERTINTO', 'VALUES', 'USINGTTL'];
  }

  public function usingTtl($ttl)
  {
    $clause = new TtlClause();
    if(!($ttl instanceof NumericExpression))
    {
      $ttl = NumericExpression::create((int)$ttl);
    }
    $clause->setTtl($ttl);
    $this->addClause($clause);
    return $this;
  }
}
