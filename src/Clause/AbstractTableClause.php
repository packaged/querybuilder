<?php
namespace Packaged\QueryBuilder\Clause;

abstract class AbstractTableClause implements IClause
{
  protected $_table;

  public function setTableName($table)
  {
    $this->_table = $table;
    return $this;
  }

  public function getTableName()
  {
    return $this->_table;
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return $this->getAction() . ' ' . $this->getTableName();
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return false;
  }
}
