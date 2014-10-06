<?php
namespace Packaged\QueryBuilder\Expression;

class ArrayExpression extends ValueExpression
{
  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return '("' . implode('","', $this->_value) . '")';
  }
}
