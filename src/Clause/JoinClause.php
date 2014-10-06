<?php
namespace Packaged\QueryBuilder\Clause;

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

  /**
   * @return string
   */
  public function getAction()
  {
    return 'JOIN';
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return $this->getAction() . ' ' . $this->getTableName() . ' ON '
    . $this->_src[0] . '.' . $this->_src[1] . ' = '
    . $this->_dest[0] . '.' . $this->_dest[1]
    . ($this->hasPredicates() ?
      ' AND ' .
      implode($this->getGlue(), mpull($this->getPredicates(), 'assemble'))
      : '');
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return true;
  }
}
