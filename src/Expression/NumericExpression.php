<?php
namespace Packaged\QueryBuilder\Expression;

class NumericExpression extends ValueExpression
{
  public function getValue()
  {
    if(stristr($this->_value, '.'))
    {
      return (float)$this->_value;
    }

    return (int)$this->_value;
  }
}
