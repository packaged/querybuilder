<?php
namespace Packaged\QueryBuilder\Statement;

interface IStatementSegment
{
  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble();
}
