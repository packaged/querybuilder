<?php
namespace Packaged\QueryBuilder\SelectExpression;

class FormatSelectExpression extends FunctionSelectExpression
{
  protected $_precision = 0;

  public function setPrecision($precision = 0)
  {
    $this->_precision = $precision;
    return $this;
  }

  public function getPrecision()
  {
    return $this->_precision;
  }

  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'FORMAT';
  }

  protected function _getFieldForAssemble()
  {
    return $this->getFunctionName() . '(' . $this->_field
    . ($this->_precision > 0 ? ',' . $this->_precision : '')
    . ')';
  }
}
