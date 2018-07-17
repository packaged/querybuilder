<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\Helpers\Strings;
use Packaged\QueryBuilder\SelectExpression\Traits\AliasTrait;
use Packaged\QueryBuilder\Statement\QueryStatement;

class SubQuerySelectExpression implements ISelectExpression
{
  use AliasTrait;

  /**
   * @var QueryStatement
   */
  protected $_query;

  public function getQuery()
  {
    return $this->_query;
  }

  public function setQuery(QueryStatement $query, $alias = null)
  {
    $this->_alias = $alias;
    if($this->_alias === null)
    {
      $this->_alias = 't' . Strings::randomString(5);
    }
    $this->_query = $query;
    return $this;
  }

  public static function create(QueryStatement $query, $alias = null)
  {
    $expression = new static();
    $expression->setQuery($query, $alias);
    return $expression;
  }
}
