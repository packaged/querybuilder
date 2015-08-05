<?php
namespace Packaged\QueryBuilder\Expression;

use Packaged\QueryBuilder\Expression\Traits\ValueTrait;

class ValueExpression implements IExpression
{
  use ValueTrait;

  public static function create($value)
  {
    $expression = new static;
    $expression->setValue($value);
    return $expression;
  }
}
