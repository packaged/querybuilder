<?php
namespace Packaged\QueryBuilder\Expression;

abstract class AbstractArithmeticExpression implements IExpression
{
  /**
   * @var IExpression
   */
  protected $_value;
  /**
   * @var FieldExpression
   */
  protected $_field;
  protected $_defaultValue = null;

  public function setField($field, $table = null)
  {
    $this->_field = is_scalar($field) ?
      FieldExpression::createWithTable($field, $table) : $field;
    return $this;
  }

  public function getField()
  {
    return $this->_field;
  }

  /**
   * Operator e.g. +
   * @return string
   */
  abstract public function getOperator();

  public function setExpression(IExpression $value)
  {
    $this->_value = $value;
    return $this;
  }

  public function getExpression()
  {
    return $this->_value ?: ValueExpression::create($this->_defaultValue);
  }

  public static function create($field, $value = null)
  {
    $expression = new static;
    $expression->setField($field);
    /**
     * @var $expression static
     */
    if($value instanceof IExpression)
    {
      $expression->setExpression($value);
    }
    else
    {
      $expression->setExpression(ValueExpression::create($value));
    }
    return $expression;
  }

  /**
   * @param $field
   * @param $table
   * @param $value
   *
   * @return static
   */
  public static function createWithTable($field, $table, $value = null)
  {
    $expression = new static;
    $expression->setField($field, $table);
    /**
     * @var $expression static
     */
    if($value instanceof IExpression)
    {
      $expression->setExpression($value);
    }
    else
    {
      $expression->setExpression(ValueExpression::create($value));
    }
    return $expression;
  }
}
