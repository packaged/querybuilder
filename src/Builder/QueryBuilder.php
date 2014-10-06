<?php
namespace Packaged\QueryBuilder\Builder;

use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\Statement\QueryStatement;

class QueryBuilder
{
  public static function select()
  {
    $select = new SelectClause();
    $select->addFields(func_get_args());
    $statement = new QueryStatement();
    $statement->addClause($select);
    return $statement;
  }
}
