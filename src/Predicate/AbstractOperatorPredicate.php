<?php
namespace Packaged\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Expression\ExpressionInterface;
use Packaged\QueryBuilder\Expression\NullExpression;

abstract class AbstractOperatorPredicate implements PredicateInterface
{
  protected $_field;
  /**
   * @var ExpressionInterface
   */
  protected $_value;

  /**
   * Operator e.g. =, >= >
   * @return string
   */
  abstract public function getOperator();

  public function setField($field)
  {
    $this->_field = $field;
    return $this;
  }

  public function getField()
  {
    return $this->_field;
  }

  public function setExpression(ExpressionInterface $value)
  {
    $this->_value = $value;
    return $this;
  }

  public function getExpression()
  {
    return $this->_value === null ? new NullExpression() : $this->_value;
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return $this->_field . ' '
    . $this->getOperator() . ' '
    . $this->getExpression()->assemble();
  }
}
