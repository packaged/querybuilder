<?php
namespace Packaged\QueryBuilder\Expression\Traits;

use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\SelectExpression\TableSelectExpression;

trait TableTrait
{
  protected $_table;

  public function setTable($table)
  {
    $this->_table = $table;
    return $this;
  }

  public function getTable()
  {
    if($this->_table instanceof TableExpression)
    {
      return $this->_table;
    }
    else if($this->_table instanceof TableSelectExpression)
    {
      if($this->_table->getAlias())
      {
        return TableExpression::create($this->_table->getAlias());
      }
      else
      {
        /** @var TableExpression $tbl */
        $tbl = $this->_table->getTable();
        return TableExpression::create($tbl->getTableName());
      }
    }
    else if($this->_table !== null)
    {
      return TableExpression::create($this->_table);
    }
    return $this->_table;
  }

  public function hasTable()
  {
    return $this->_table !== null;
  }
}
