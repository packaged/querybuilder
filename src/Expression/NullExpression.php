<?php
namespace Packaged\QueryBuilder\Expression;

class NullExpression implements ExpressionInterface
{
  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return 'NULL';
  }
}
