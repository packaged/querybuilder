<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Statement\QueryStatement;

class SubQuerySelectExpression implements SelectExpressionInterface
{
  /**
   * @var QueryStatement
   */
  protected $_query;
  protected $_alias;

  public function setQuery(QueryStatement $query, $alias = null)
  {
    $this->_alias = $alias;
    if($this->_alias === null)
    {
      $this->_alias = substr(md5($query->assemble()), 0, 6);
    }
    $this->_query = $query;
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return '(' . $this->_query->assemble() . ') AS ' . $this->_alias;
  }
}
