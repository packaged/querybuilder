<?php
namespace Packaged\QueryBuilder\Expression;

class DecrementExpression extends FieldExpression
{
  protected $_decrement = 0;

  public function setDecrementValue($increment = 1)
  {
    $this->_decrement = $increment;
    return $this;
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return parent::assemble() . ' - ' . (int)$this->_decrement;
  }
}
