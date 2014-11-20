<?php
namespace Packaged\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Expression\IExpression;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;

abstract class AbstractOperatorPredicate implements IPredicate
{
  /**
   * @var FieldExpression
   */
  protected $_field;
  /**
   * @var IExpression
   */
  protected $_value;

  /**
   * Operator e.g. =, >= >
   * @return string
   */
  abstract public function getOperator();

  public function setField($field)
  {
    $this->_field = is_scalar($field) ?
      FieldExpression::create($field) : $field;
    return $this;
  }

  public function getField()
  {
    return $this->_field;
  }

  public function setExpression(IExpression $value)
  {
    $this->_value = $value;
    return $this;
  }

  public function getExpression()
  {
    return $this->_value === null ? new ValueExpression() : $this->_value;
  }

  public function isNullValue()
  {
    if($this->_value === null)
    {
      return true;
    }
    else if($this->_value instanceof ValueExpression)
    {
      return $this->_value->getValue() === null;
    }
    return false;
  }
}
