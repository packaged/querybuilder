<?php
namespace Packaged\QueryBuilder\SelectExpression;

class SubStringSelectExpression extends FunctionSelectExpression
{
  protected $_position = 0;
  protected $_length;

  public function setStartPosition($position)
  {
    $this->_position = $position;
    return $this;
  }

  public function setLength($length)
  {
    $this->_length = $length;
    return $length;
  }

  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'SUBSTRING';
  }

  protected function _getFieldForAssemble()
  {
    return $this->getFunctionName()
    . '(' . $this->_field
    . ',' . $this->_position
    . ($this->_length !== null ? ',' . $this->_length : '')
    . ')';
  }

  public static function create(
    $field, $start = 0, $length = null, $alias = null
  )
  {
    $expression = parent::createWithAlias($field, $alias);
    /**
     * @var $expression static
     */
    $expression->setStartPosition($start);
    if($length !== null)
    {
      $expression->setLength($length);
    }
    return $expression;
  }
}
