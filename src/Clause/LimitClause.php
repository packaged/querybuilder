<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;

class LimitClause implements IClause
{
  protected $_limit;
  protected $_offset;

  public function setLimit($limit)
  {
    if(!($limit instanceof ValueExpression))
    {
      $limit = NumericExpression::create($limit);
    }
    $this->_limit = $limit;
    return $this;
  }

  /**
   * @return ValueExpression
   */
  public function getLimit()
  {
    return $this->_limit;
  }

  public function setOffset($offset)
  {
    if(!($offset instanceof ValueExpression))
    {
      $offset = NumericExpression::create($offset);
    }
    $this->_offset = $offset;
    return $this;
  }

  /**
   * @return ValueExpression
   */
  public function getOffset()
  {
    return $this->_offset;
  }

  public function hasOffset()
  {
    return $this->_offset !== null;
  }

  /**
   * @return string
   */
  public function getAction()
  {
    return 'LIMIT';
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return false;
  }
}
