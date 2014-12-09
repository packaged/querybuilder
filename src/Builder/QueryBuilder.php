<?php
namespace Packaged\QueryBuilder\Builder;

use Packaged\QueryBuilder\Clause\DeleteClause;
use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\Statement\DeleteStatement;
use Packaged\QueryBuilder\Statement\QueryStatement;

class QueryBuilder
{
  public static function select(...$expressions)
  {
    $select = new SelectClause();
    $select->addFields($expressions);
    $statement = new QueryStatement();
    $statement->addClause($select);
    return $statement;
  }

  public static function selectDistinct(...$expressions)
  {
    $select = new SelectClause();
    $select->setDistinct(true);
    $select->addFields($expressions);
    $statement = new QueryStatement();
    $statement->addClause($select);
    return $statement;
  }

  public static function deleteFrom($from, ...$expressions)
  {
    $statement = new DeleteStatement();
    $statement->addClause((new DeleteClause())->setTable($from));
    if(!empty($expressions))
    {
      $statement->where(...$expressions);
    }
    return $statement;
  }
}
