<?php
namespace Packaged\QueryBuilder\SelectExpression;

class FieldSelectExpression implements SelectExpressionInterface
{
  protected $_field;
  protected $_alias;

  public function setField($field)
  {
    $this->_field = $field;
    return $this;
  }

  public function getField()
  {
    return $this->_field;
  }

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

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return $this->_getFieldForAssemble()
    . ($this->hasAlias() ? ' AS ' . $this->_alias : '');
  }

  protected function _getFieldForAssemble()
  {
    return $this->_field;
  }
}
