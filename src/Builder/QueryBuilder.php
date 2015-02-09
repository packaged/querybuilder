<?php
namespace Packaged\QueryBuilder\Builder;

use Packaged\QueryBuilder\Clause\DeleteClause;
use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\Statement\DeleteStatement;
use Packaged\QueryBuilder\Statement\InsertStatement;
use Packaged\QueryBuilder\Statement\QueryStatement;
use Packaged\QueryBuilder\Statement\UpdateStatement;

class QueryBuilder
{
  protected static function _getQueryStatement()
  {
    return new QueryStatement();
  }

  protected static function _getInsertStatement()
  {
    return new InsertStatement();
  }

  public static function select(...$expressions)
  {
    $select = new SelectClause();
    $select->addFields($expressions);
    $statement = static::_getQueryStatement();
    $statement->addClause($select);
    return $statement;
  }

  public static function selectDistinct(...$expressions)
  {
    $select = new SelectClause();
    $select->setDistinct(true);
    $select->addFields($expressions);
    $statement = static::_getQueryStatement();
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

  public static function insertInto($table, ...$fields)
  {
    $statement = static::_getInsertStatement();
    $statement->insertInto($table, ...$fields);
    return $statement;
  }

  public static function update($table, array $keyValues = null)
  {
    $statement = new UpdateStatement();
    $statement->update($table);
    if(!empty($keyValues))
    {
      foreach($keyValues as $field => $value)
      {
        $statement->set($field, $value);
      }
    }
    return $statement;
  }
}
