<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Expression\FieldExpression;

class FieldSelectExpression extends FieldExpression
  implements SelectExpressionInterface
{
  protected $_alias;

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
