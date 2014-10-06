<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;
use Packaged\QueryBuilder\SelectExpression\SelectExpressionInterface;

class SelectClause implements ClauseInterface
{
  protected $_expressions = [];

  public function addExpression(SelectExpressionInterface $expression)
  {
    $this->_expressions[] = $expression;
    return $this;
  }

  public function setExpressions(array $expressions)
  {
    $this->_expressions = assert_instances_of(
      $expressions,
      '\Packaged\QueryBuilder\SelectExpression\SelectExpressionInterface'
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

  public function addFields($fields)
  {
    foreach($fields as $alias => $field)
    {
      $this->addField($field, is_int($alias) ? null : $alias);
    }
    return $this;
  }

  public function addField($field, $alias = null)
  {
    if($field instanceof SelectExpressionInterface)
    {
      $this->addExpression($field);
    }
    else if(is_scalar($field))
    {
      $this->addExpression(FieldSelectExpression::create($field, $alias));
    }
    else
    {
      throw new \InvalidArgumentException("Invalid field type entered");
    }
    return $this;
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return false;
  }
}
