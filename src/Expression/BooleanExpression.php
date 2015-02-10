<?php
namespace Packaged\QueryBuilder\Expression;

class BooleanExpression extends ValueExpression
{
  public function getValue()
  {
    return (bool)$this->_value;
  }
}
