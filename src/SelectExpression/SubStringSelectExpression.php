<?php
namespace Packaged\QueryBuilder\SelectExpression;

class SubStringSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'MID';
  }
}
