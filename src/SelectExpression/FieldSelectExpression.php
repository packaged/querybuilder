<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\IExpression;
use Packaged\QueryBuilder\SelectExpression\Traits\AliasTrait;

class FieldSelectExpression implements ISelectExpression
{
  use AliasTrait;

  protected $_field;
  protected $_collation = '';

  public function setField($field, $table = null)
  {
    if($field === null || $field instanceof IExpression)
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

  /**
   * @param string $collation
   *
   * @return $this
   */
  public function setCollation($collation)
  {
    $this->_collation = $collation;
    return $this;
  }

  /**
   * @return string
   */
  public function getCollation()
  {
    return $this->_collation;
  }

  /**
   * @param $field
   *
   * @return static
   */
  public static function create($field)
  {
    $expression = new static();
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
    $expression = new static();
    $expression->setField($field);
    if($alias !== null)
    {
      $expression->setAlias($alias);
    }
    return $expression;
  }
}
