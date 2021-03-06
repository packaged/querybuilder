<?php
namespace Packaged\QueryBuilder\Expression;

class UnixTimestampExpression implements IExpression
{
  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function getFunction()
  {
    return 'UNIX_TIMESTAMP()';
  }
}
