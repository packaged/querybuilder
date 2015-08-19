<?php
namespace Packaged\QueryBuilder\Expression;

class TableExpression implements IExpression
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
   * @param $table
   *
   * @return static
   */
  public static function create($table)
  {
    return (new static)->setTableName($table);
  }
}
