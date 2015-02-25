<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Expression\IExpression;

class ExpressionSelectExpression implements ISelectExpression
{
  protected $_expression;
  protected $_alias;

  public function setExpression(IExpression $expr)
  {
    $this->_expression = $expr;
  }

  public function getExpression()
  {
    return $this->_expression;
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
   * @param $expression
   *
   * @return static
   */
  public static function create($expression)
  {
    $expr = new static;
    $expr->setExpression($expression);
    return $expr;
  }

  /**
   * @param $expression
   * @param $alias
   *
   * @return static
   */
  public static function createWithAlias($expression, $alias)
  {
    $expr = static::create($expression);
    $expr->setAlias($alias);
    return $expr;
  }
}
