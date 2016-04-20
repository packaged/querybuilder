<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Expression\IExpression;
use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\SelectExpression\Traits\AliasTrait;

class TableSelectExpression implements ISelectExpression
{
  use AliasTrait;

  protected $_table;

  public function setTable($field)
  {
    if($field === null || $field instanceof IExpression)
    {
      $this->_table = $field;
    }
    else
    {
      $this->_table = TableExpression::create($field);
    }
    return $this;
  }

  /**
   * @return TableExpression
   */
  public function getTable()
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
    $expression = new static;
    $expression->setTable($table);
    return $expression;
  }

  /**
   * @param $table
   * @param $alias
   *
   * @return static
   */
  public static function createWithAlias($table, $alias)
  {
    $expression = new static;
    $expression->setTable($table);
    if($alias !== null)
    {
      $expression->setAlias($alias);
    }
    return $expression;
  }
}
