<?php
namespace Packaged\QueryBuilder\SelectExpression;

class MaxSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'MAX';
  }
}
