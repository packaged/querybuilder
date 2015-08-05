<?php
namespace Packaged\QueryBuilder\Expression\Traits;

trait FieldTrait
{
  protected $_field;

  public function setField($field)
  {
    $this->_field = $field;
    return $this;
  }

  public function getField()
  {
    return $this->_field;
  }

}
