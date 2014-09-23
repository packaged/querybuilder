<?php
namespace Packaged\QueryBuilder\SelectExpression;

class AverageSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'AVG';
  }
}
