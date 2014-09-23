<?php
namespace Packaged\QueryBuilder\Predicate;

use Packaged\QueryBuilder\QueryColumn\SelectExpressionInterface;

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
}
