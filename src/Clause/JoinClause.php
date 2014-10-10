<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\TableExpression;

class JoinClause extends AbstractPredicateClause
{
  protected $_table;
  protected $_src = [null, null];
  protected $_dest = [null, null];

  public function setTableName($table)
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
    return TableExpression::create($this->_table);
  }

  public function setSourceField($table, $field)
  {
    $this->_src = [$table, $field];
  }

  public function setDestinationField($table, $field)
  {
    $this->_dest = [$table, $field];
  }

  public function getSource()
  {
    return FieldExpression::createWithTable($this->_src[1], $this->_src[0]);
  }

  public function getDestination()
  {
    return FieldExpression::createWithTable($this->_dest[1], $this->_dest[0]);
  }

  /**
   * @return string
   */
  public function getAction()
  {
    return 'JOIN';
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return true;
  }
}
