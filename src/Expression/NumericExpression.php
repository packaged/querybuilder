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
    if(stristr($this->_value, '.'))
    {
      return (float)$this->_value;
    }

    return (int)$this->_value;
  }
}
