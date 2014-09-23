<?php
namespace Packaged\QueryBuilder\Expression;

class StringExpression implements ExpressionInterface
{
  protected $_value;

  public function __construct($value)
  {
    $this->_value = $value;
  }

  /**
   * @return string
   */
  public function build()
  {
    return '"' . $this->_value . '"';
  }
}
