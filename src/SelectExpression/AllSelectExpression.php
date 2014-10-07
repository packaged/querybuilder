<?php
namespace Packaged\QueryBuilder\SelectExpression;

class AllSelectExpression implements ISelectExpression
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

  /**
   * Create a new Select * Expression with a table prefix
   * e.g. table.*
   *
   * @param $table
   *
   * @return static
   */
  public static function create($table = null)
  {
    $select = new static;
    if($table !== null)
    {
      $select->setTable($table);
    }
    return $select;
  }
}
