<?php
namespace Packaged\QueryBuilder\Expression;

class StringExpression extends ValueExpression
{
  protected $_collation = '';

  /**
   * @param string $collation
   *
   * @return $this
   */
  public function setCollation($collation)
  {
    $this->_collation = $collation;
    return $this;
  }

  /**
   * @return string
   */
  public function getCollation()
  {
    return $this->_collation;
  }
}
