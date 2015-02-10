<?php
namespace Packaged\QueryBuilder\Builder\Traits\CQL;

use Packaged\QueryBuilder\Clause\CQL\UsingClause;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Statement\IStatement;

trait UsingTrait
{
  public function usingTtl($ttl)
  {
    /**
     * @var $this IStatement
     */
    $clause = $this->getClause('USING');
    if($clause === null)
    {
      $clause = new UsingClause();
      $this->addClause($clause);
    }
    if(!($ttl instanceof NumericExpression))
    {
      $ttl = NumericExpression::create((int)$ttl);
    }
    $clause->setTtl($ttl);
    return $this;
  }

  public function usingTimestamp($timestamp)
  {
    /**
     * @var $this IStatement
     */
    $clause = $this->getClause('USING');
    if($clause === null)
    {
      $clause = new UsingClause();
      $this->addClause($clause);
    }
    if(!($timestamp instanceof NumericExpression))
    {
      $timestamp = NumericExpression::create((int)$timestamp);
    }
    $clause->setTimestamp($timestamp);
    return $this;
  }
}
