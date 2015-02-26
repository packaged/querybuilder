<?php
namespace Packaged\QueryBuilder\SelectExpression;

class CustomSelectExpression extends FieldSelectExpression
{
  protected $_field;

  public function setField($field, $table = null)
  {
    $this->_field = $field;
    return $this;
  }

  public function getField()
  {
    return $this->_field;
  }
}
