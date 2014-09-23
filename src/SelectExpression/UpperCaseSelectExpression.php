<?php
namespace Packaged\QueryBuilder\SelectExpression;

class UpperCaseSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'UCASE';
  }
}
