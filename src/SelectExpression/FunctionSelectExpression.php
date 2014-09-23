<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Predicate\FieldSelectExpression;

abstract class FunctionSelectExpression extends FieldSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  abstract public function getFunctionName();
}
