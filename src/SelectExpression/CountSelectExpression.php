<?php
namespace Packaged\QueryBuilder\SelectExpression;

class CountSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'COUNT';
  }
}
