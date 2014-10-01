<?php
namespace Packaged\QueryBuilder\Expression;

class IncrementExpression extends FieldExpression
{
  protected $_increment = 0;

  public function setIncrementValue($increment = 1)
  {
    $this->_increment = $increment;
    return $this;
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return parent::assemble() . ' + ' . (int)$this->_increment;
  }
}
