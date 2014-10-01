<?php
namespace Packaged\QueryBuilder\Statement;

interface StatementInterface
{
  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble();
}
