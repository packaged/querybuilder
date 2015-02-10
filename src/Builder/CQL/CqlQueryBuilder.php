<?php
namespace Packaged\QueryBuilder\Builder\CQL;

use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Statement\CQL\CqlInsertStatement;
use Packaged\QueryBuilder\Statement\CQL\CqlQueryStatement;
use Packaged\QueryBuilder\Statement\CQL\CqlUpdateStatement;

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

  protected static function _getUpdateStatement()
  {
    return new CqlUpdateStatement();
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

  /**
   * @param $table
   * @param $keyValues
   *
   * @return CqlUpdateStatement
   */
  public static function update($table, array $keyValues = null)
  {
    return parent::update($table, $keyValues);
  }
}
