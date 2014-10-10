<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\SelectExpression\ConcatSelectExpression;
use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;
use Packaged\QueryBuilder\SelectExpression\ISelectExpression;

class SelectClause implements IClause
{
  protected $_expressions = [];
  protected $_distinct = false;

  public function setDistinct($distinct = true)
  {
    $this->_distinct = $distinct;
    return $this;
  }

  public function isDistinct()
  {
    return (bool)$this->_distinct;
  }

  public function addExpression(ISelectExpression $expression)
  {
    $this->_expressions[] = $expression;
    return $this;
  }

  public function setExpressions(array $expressions)
  {
    $this->_expressions = assert_instances_of(
      $expressions,
      '\Packaged\QueryBuilder\SelectExpression\ISelectExpression'
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
    if($field instanceof ISelectExpression)
    {
      $this->addExpression($field);
    }
    else if(is_scalar($field))
    {
      $this->addExpression(FieldSelectExpression::create($field, $alias));
    }
    else if(is_array($field))
    {
      foreach($field as $fName => $values)
      {
        $expr = new ConcatSelectExpression();
        $expr->setPropertyArray($values);
        $expr->setAlias($fName);
        $this->addExpression($expr);
      }
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
