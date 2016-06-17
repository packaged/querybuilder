<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\TableExpression;

class JoinClause extends AbstractPredicateClause
{
  protected $_table;
  protected $_src = null;
  protected $_dest = null;

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
    elseif(is_scalar($this->_table))
    {
      return TableExpression::create($this->_table);
    }
    return $this->_table;
  }

  public function setSourceField($table, $field)
  {
    $this->_src = [$table, $field];
    return $this;
  }

  public function setDestinationField($table, $field)
  {
    $this->_dest = [$table, $field];
    return $this;
  }

  public function getSource()
  {
    if(is_array($this->_src))
    {
      return FieldExpression::createWithTable($this->_src[1], $this->_src[0]);
    }
    return $this->_src;
  }

  public function getDestination()
  {
    if(is_array($this->_dest))
    {
      return FieldExpression::createWithTable($this->_dest[1], $this->_dest[0]);
    }
    return $this->_dest;
  }

  /**
   * @return string
   */
  public function getAction()
  {
    return 'INNER JOIN';
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return true;
  }
}
