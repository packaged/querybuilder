<?php
namespace Packaged\QueryBuilder\Expression;

class NumericExpression extends ValueExpression
{
  public function getValue()
  {
    if(stristr($this->_value, '.'))
    {
      return filter_var(
        $this->_value,
        FILTER_SANITIZE_NUMBER_FLOAT,
        FILTER_FLAG_ALLOW_FRACTION
      );
    }

    return filter_var($this->_value, FILTER_SANITIZE_NUMBER_INT) ?: 0;
  }
}
