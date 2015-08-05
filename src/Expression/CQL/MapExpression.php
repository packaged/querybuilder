<?php
namespace Packaged\QueryBuilder\Expression\CQL;

use Packaged\Helpers\Arrays;

class MapExpression extends SetExpression
{
  public static function create($value)
  {
    if(!is_array($value) || !Arrays::isAssoc($value))
    {
      throw new \InvalidArgumentException('Map requires an associative array');
    }
    return parent::create($value);
  }
}
