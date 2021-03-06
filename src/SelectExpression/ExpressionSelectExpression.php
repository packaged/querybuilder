<?php
namespace Packaged\QueryBuilder\SelectExpression;

class ExpressionSelectExpression extends FieldSelectExpression
{
  protected $_expression;

  public function setField($field, $table = null)
  {
    $this->_expression = $field;
  }

  public function getField()
  {
    return $this->_expression;
  }
}
