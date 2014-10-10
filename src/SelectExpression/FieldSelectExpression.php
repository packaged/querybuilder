<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Expression\FieldExpression;

class FieldSelectExpression implements ISelectExpression
{
  protected $_field;
  protected $_alias;

  public function setField($field, $table = null)
  {
    if($field instanceof FieldExpression)
    {
      $this->_field = $field;
    }
    else
    {
      $this->_field = FieldExpression::createWithTable($field, $table);
    }
    return $this;
  }

  /**
   * @return FieldExpression
   */
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
