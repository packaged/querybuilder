<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Expression\ExpressionInterface;

class ValuesClause implements ClauseInterface
{
  protected $_expressions = [];

  public function addExpression(ExpressionInterface $expression)
  {
    $this->_expressions[] = $expression;
    return $this;
  }

  public function setExpressions(array $expressions)
  {
    $this->_expressions = assert_instances_of(
      $expressions,
      '\Packaged\QueryBuilder\Expression\ExpressionInterface'
    );
    return $this;
  }

  public function clearExpressions()
  {
    $this->_expressions = [];
    return $this;
  }

  public function getExpressions()
  {
    return $this->_expressions;
  }

  public function hasExpressions()
  {
    return !empty($this->_expressions);
  }

  /**
   * @return string
   */
  public function getAction()
  {
    return 'VALUES';
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return $this->getAction() . ' ('
    . implode(', ', mpull($this->_expressions, 'assemble'))
    . ')';
  }
}
