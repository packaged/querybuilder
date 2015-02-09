<?php
namespace Packaged\QueryBuilder\Builder\CQL;

use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Statement\CQL\CqlInsertStatement;
use Packaged\QueryBuilder\Statement\CQL\CqlQueryStatement;

class CqlQueryBuilder extends QueryBuilder
{
  protected static function _getQueryStatement()
  {
    return new CqlQueryStatement();
  }

  protected static function _getInsertStatement()
  {
    return new CqlInsertStatement();
  }

  /**
   * @param ...$expressions
   *
   * @return CqlQueryStatement
   */
  public static function select(...$expressions)
  {
    return parent::select(...$expressions);
  }

  /**
   * @param $table
   * @param ...$fields
   *
   * @return CqlInsertStatement
   */
  public static function insertInto($table, ...$fields)
  {
    return parent::insertInto($table, ...$fields);
  }
}
