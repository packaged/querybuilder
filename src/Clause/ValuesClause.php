<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\Helpers\Arrays;
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
    $this->_expressions = Arrays::instancesOf(
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
   * @return bool
   */
  public function allowMultiple()
  {
    return true;
  }
}
