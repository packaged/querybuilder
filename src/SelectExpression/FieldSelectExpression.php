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

  /**
   * @param $field
   *
   * @return static
   */
  public static function create($field)
  {
    $expression = new static;
    $expression->setField($field);
    return $expression;
  }

  /**
   * @param $field
   * @param $alias
   *
   * @return static
   */
  public static function createWithAlias($field, $alias)
  {
    $expression = new static;
    $expression->setField($field);
    if($alias !== null)
    {
      $expression->setAlias($alias);
    }
    return $expression;
  }
}
