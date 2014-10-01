<?php
namespace Packaged\QueryBuilder\SelectExpression;

class AllSelectExpression implements SelectExpressionInterface
{
  protected $_table;

  public function setTable($table)
  {
    $this->_table = $table;
    return $this;
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return $this->_table === null ? '*' : $this->_table . '.*';
  }
}
