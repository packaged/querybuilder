<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Expression\FieldExpression;

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

  public function getTableName()
  {
    return $this->_table;
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
