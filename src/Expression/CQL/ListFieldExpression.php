<?php
namespace Packaged\QueryBuilder\Expression\CQL;

class ListFieldExpression extends MapFieldExpression
{
  public static function create($field, $key = null)
  {
    if(!is_numeric($key))
    {
      throw new \InvalidArgumentException(
        'Key must be numeric for ListFieldExpression'
      );
    }
    return parent::create($field, $key);
  }
}
