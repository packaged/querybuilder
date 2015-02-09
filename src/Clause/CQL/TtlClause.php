<?php
namespace Packaged\QueryBuilder\Clause\CQL;

use Packaged\QueryBuilder\Clause\IClause;
use Packaged\QueryBuilder\Expression\NumericExpression;

class TtlClause implements IClause
{
  protected $_ttl;

  public function setTtl(NumericExpression $ttl)
  {
    $this->_ttl = $ttl;
    return $this;
  }

  public function getTtl()
  {
    return $this->_ttl;
  }

  /**
   * @return string
   */
  public function getAction()
  {
    return 'USING TTL';
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return false;
  }
}
