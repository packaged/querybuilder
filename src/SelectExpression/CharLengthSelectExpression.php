<?php
namespace Packaged\QueryBuilder\SelectExpression;

class CharLengthSelectExpression extends FunctionSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'CHAR_LENGTH';
  }
}
