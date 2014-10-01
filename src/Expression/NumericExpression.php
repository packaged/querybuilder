<?php
namespace Packaged\QueryBuilder\Expression;

class NumericExpression extends ValueExpression
{
  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return $this->_value;
  }
}
