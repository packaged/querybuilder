<?php
namespace Packaged\QueryBuilder\SelectExpression;

/**
 * Fields to concat together should be specified individually into the contructor
 * and strings should be quoted before pushing through
 */
class ConcatSelectExpression implements SelectExpressionInterface
{
  protected $_alias;
  protected $_properties;

  public function setAlias($alias)
  {
    $this->_alias = $alias;
    return $this;
  }

  public function getAlias()
  {
    return $this->_alias;
  }

  public function hasAlias()
  {
    return $this->_alias !== null;
  }

  public function setProperties()
  {
    $this->_properties = func_get_args();
  }

  public function setPropertyArray($properties)
  {
    $this->_properties = $properties;
    return $this;
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return 'CONCAT(' . implode(',', $this->_properties) . ')'
    . ($this->hasAlias() ? ' AS ' . $this->getAlias() : '');
  }

  public static function create()
  {
    $expression              = new static;
    $expression->_properties = func_get_args();
    return $expression;
  }
}
