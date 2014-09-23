<?php
namespace Packaged\QueryBuilder\SelectExpression;

class SumSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'SUM';
  }
}
