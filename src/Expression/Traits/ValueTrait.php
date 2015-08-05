<?php
namespace Packaged\QueryBuilder\Expression\Traits;

trait ValueTrait
{
  protected $_value;

  public function setValue($value)
  {
    $this->_value = $value;
    return $this;
  }

  public function getValue()
  {
    return $this->_value;
  }
}
