<?php
namespace Packaged\QueryBuilder\Expression;

use Packaged\QueryBuilder\Expression\Traits\FieldTrait;
use Packaged\QueryBuilder\Expression\Traits\TableTrait;

class FieldExpression implements IExpression
{
  use FieldTrait;
  use TableTrait;

  /**
   * @param $field
   *
   * @return static
   */
  public static function create($field)
  {
    $expression = new static;
    $expression->setField($field);
    return $expression;
  }

  public static function createWithTable($field, $table)
  {
    $expression = new static;
    $expression->setField($field);
    $expression->setTable($table);
    return $expression;
  }
}
