<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\QueryColumn\SelectExpressionInterface;
use Packaged\QueryBuilder\Statement\QueryStatementInterface;

class SubQuerySelectExpression implements SelectExpressionInterface
{
  public function __construct(QueryStatementInterface $query)
  {
  }
}
