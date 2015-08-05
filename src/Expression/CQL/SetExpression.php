<?php
namespace Packaged\QueryBuilder\Expression\CQL;

use Packaged\QueryBuilder\Expression\ValueExpression;

class SetExpression extends ValueExpression
{
  public static function create($value)
  {
    if(is_scalar($value))
    {
      $value = [$value];
    }
    foreach($value as $k => $val)
    {
      if(!($val instanceof ValueExpression))
      {
        $value[$k] = ValueExpression::create($val);
      }
    }
    return parent::create($value);
  }
}
