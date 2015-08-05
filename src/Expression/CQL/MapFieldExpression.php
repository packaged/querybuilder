<?php
namespace Packaged\QueryBuilder\Expression\CQL;

use Packaged\QueryBuilder\Expression\FieldExpression;

class MapFieldExpression extends FieldExpression
{
  protected $_key;

  public static function create($field, $key = null)
  {
    $expression = new static;
    $expression->setField($field);
    $expression->setKey($key);
    return $expression;
  }

  public function setKey($key)
  {
    $this->_key = $key;
    return $this;
  }

  public function getKey()
  {
    return $this->_key;
  }
}
