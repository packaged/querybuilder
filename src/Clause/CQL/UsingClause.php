<?php
namespace Packaged\QueryBuilder\Clause\CQL;

use Packaged\QueryBuilder\Clause\IClause;
use Packaged\QueryBuilder\Expression\NumericExpression;

class UsingClause implements IClause
{
  protected $_ttl;
  protected $_timestamp;

  public function setTtl(NumericExpression $ttl)
  {
    $this->_ttl = $ttl;
    return $this;
  }

  public function getTtl()
  {
    return $this->_ttl;
  }

  public function setTimestamp(NumericExpression $timestamp)
  {
    $this->_timestamp = $timestamp;
    return $this;
  }

  public function getTimestamp()
  {
    return $this->_timestamp;
  }

  /**
   * @return string
   */
  public function getAction()
  {
    return 'USING';
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return false;
  }
}
