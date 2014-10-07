<?php
namespace Packaged\QueryBuilder\Expression;

abstract class AbstractArithmeticExpression extends FieldExpression
{
  /**
   * @var ExpressionInterface
   */
  protected $_value;

  protected $_defaultValue = null;

  /**
   * Operator e.g. +
   * @return string
   */
  abstract public function getOperator();

  public function setExpression(ExpressionInterface $value)
  {
    $this->_value = $value;
    return $this;
  }

  public function getExpression()
  {
    return $this->_value ?: ValueExpression::create($this->_defaultValue);
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return parent::assemble() . ' '
    . $this->getOperator() . ' '
    . $this->getExpression()->assemble();
  }

  public static function create($field, $value)
  {
    $expression = parent::create($field);
    /**
     * @var $expression static
     */
    if($value instanceof ExpressionInterface)
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
   * @param $value
   *
   * @return static
   */
  public static function createWithTable($field, $table, $value)
  {
    $expression = parent::createWithTable($field, $table);
    /**
     * @var $expression static
     */
    if($value instanceof ExpressionInterface)
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
