<?php
namespace Packaged\QueryBuilder\Expression;

class FieldExpression implements ExpressionInterface
{
  protected $_field;

  public function setField($field)
  {
    $this->_field = $field;
    return $this;
  }

  public function getField()
  {
    return $this->_field;
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return $this->_field;
  }
}
