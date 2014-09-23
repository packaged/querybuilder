<?php
namespace Packaged\QueryBuilder\SelectExpression;

class RoundSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'ROUND';
  }
}
