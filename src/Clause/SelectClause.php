<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\SelectExpression\SelectExpressionInterface;

class SelectClause implements ClauseInterface
{
  protected $_expressions = [];

  public function addExpression(SelectExpressionInterface $expression)
  {
    $this->_expressions[] = $expression;
  }

  public function setExpressions(array $expressions)
  {
    $this->_expressions = assert_instances_of(
      $expressions,
      '\Packaged\QueryBuilder\SelectExpression\SelectExpressionInterface'
    );
  }

  public function clearExpressions()
  {
    $this->_expressions = [];
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
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    if(!$this->hasExpressions())
    {
      return $this->getAction() . ' *';
    }

    return $this->getAction() . ' '
    . implode(', ', mpull($this->getExpressions(), 'assemble'));
  }

  public function getAction()
  {
    return 'SELECT';
  }
}
