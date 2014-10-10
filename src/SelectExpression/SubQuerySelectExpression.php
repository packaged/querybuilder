<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Statement\QueryStatement;

class SubQuerySelectExpression implements ISelectExpression
{
  /**
   * @var QueryStatement
   */
  protected $_query;
  protected $_alias;

  public function getAlias()
  {
    return $this->_alias;
  }

  public function getQuery()
  {
    return $this->_query;
  }

  public function setQuery(QueryStatement $query, $alias = null)
  {
    $this->_alias = $alias;
    if($this->_alias === null)
    {
      $this->_alias = substr(md5(QueryAssembler::stringify($query)), 0, 6);
    }
    $this->_query = $query;
  }

  public static function create(QueryStatement $query, $alias = null)
  {
    $expression = new static;
    $expression->setQuery($query, $alias);
    return $expression;
  }
}
