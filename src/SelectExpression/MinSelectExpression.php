<?php
namespace Packaged\QueryBuilder\SelectExpression;

class MinSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'MIN';
  }
}
