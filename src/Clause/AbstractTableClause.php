<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Expression\TableExpression;

abstract class AbstractTableClause implements IClause
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
    elseif(is_scalar($this->_table))
    {
      return TableExpression::create($this->_table);
    }
    return $this->_table;
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return false;
  }
}
