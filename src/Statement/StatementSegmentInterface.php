<?php
namespace Packaged\QueryBuilder\Statement;

interface StatementSegmentInterface
{
  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble();
}
