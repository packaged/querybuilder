<?php
namespace Packaged\QueryBuilder\SelectExpression\Traits;

trait AliasTrait
{
  protected $_alias;

  public function setAlias($alias)
  {
    $this->_alias = $alias;
    return $this;
  }

  public function getAlias()
  {
    return $this->_alias;
  }

  public function hasAlias()
  {
    return $this->_alias !== null;
  }
}
