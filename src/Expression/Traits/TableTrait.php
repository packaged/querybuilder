<?php
namespace Packaged\QueryBuilder\Expression\Traits;

use Packaged\QueryBuilder\Expression\TableExpression;

trait TableTrait
{
  protected $_table;

  public function setTable($table)
  {
    if($table instanceof TableExpression)
    {
      $this->_table = $table;
    }
    else if($table !== null)
    {
      $this->_table = TableExpression::create($table);
    }
    return $this;
  }

  public function getTable()
  {
    return $this->_table;
  }

  public function hasTable()
  {
    return $this->_table !== null;
  }
}
