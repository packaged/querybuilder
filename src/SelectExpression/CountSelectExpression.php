<?php
namespace Packaged\QueryBuilder\SelectExpression;

class CountSelectExpression extends FunctionSelectExpression
{
  protected $_distinct = false;

  public function setDistinct($distinct = true)
  {
    $this->_distinct = $distinct;
    return $this;
  }

  public function isDistinct()
  {
    return (bool)$this->_distinct;
  }

  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'COUNT';
  }

  public static function create($field = null)
  {
    return parent::create($field);
  }
}
