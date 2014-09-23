<?php
namespace Packaged\QueryBuilder\SelectExpression;

class LastSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'LAST';
  }
}
