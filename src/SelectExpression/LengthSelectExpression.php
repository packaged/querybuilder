<?php
namespace Packaged\QueryBuilder\SelectExpression;

class LengthSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'LENGTH';
  }
}
