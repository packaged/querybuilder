<?php
namespace Packaged\QueryBuilder\SelectExpression;

class FirstSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'FIRST';
  }
}
