<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\QueryColumn\SelectExpressionInterface;

class ConcatSelectExpression implements SelectExpressionInterface
{
  protected $_properties;

  public function __construct()
  {
    $this->_properties = func_get_args();
  }
}
