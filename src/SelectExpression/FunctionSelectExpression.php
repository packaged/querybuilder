<?php
namespace Packaged\QueryBuilder\SelectExpression;

abstract class FunctionSelectExpression extends FieldSelectExpression
{
  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  abstract public function getFunctionName();

  protected function _getFieldForAssemble()
  {
    return $this->getFunctionName() . '(' . $this->_field . ')';
  }
}
