<?php
namespace Packaged\QueryBuilder\SelectExpression;

/**
 * Fields to concat together should be specified individually into the contructor
 * and strings should be quoted before pushing through
 */
class ConcatSelectExpression implements SelectExpressionInterface
{
  protected $_properties;

  public function setProperties()
  {
    $this->_properties = func_get_args();
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return 'CONCAT(' . implode(',', $this->_properties) . ')';
  }

  public static function create()
  {
    $expression              = new static;
    $expression->_properties = func_get_args();
    return $expression;
  }
}
