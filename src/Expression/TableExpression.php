<?php
namespace Packaged\QueryBuilder\Expression;

class TableExpression implements IExpression
{
  protected $_table;
  protected $_database;

  /**
   * @return string|null
   */
  public function getDatabase()
  {
    return $this->_database;
  }

  public function setDatabase($database)
  {
    $this->_database = $database;
    return $this;
  }

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
   * @param $database
   *
   * @return \Packaged\QueryBuilder\Expression\TableExpression
   */
  public static function create($table, $database = null)
  {
    return (new static())->setTableName($table)->setDatabase($database);
  }
}
