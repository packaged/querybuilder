<?php
namespace Packaged\QueryBuilder\SelectExpression;

class FormatSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'FORMAT';
  }
}
