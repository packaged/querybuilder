<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Expression\IExpression;

class ValuesClause implements IClause
{
  protected $_expressions = [];

  public function addExpression(IExpression $expression)
  {
    $this->_expressions[] = $expression;
    return $this;
  }

  public function setExpressions(array $expressions)
  {
    $this->_expressions = assert_instances_of(
      $expressions,
      '\Packaged\QueryBuilder\Expression\IExpression'
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

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return true;
  }
}
