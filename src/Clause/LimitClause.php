<?php
namespace Packaged\QueryBuilder\Clause;

class LimitClause implements IClause
{
  protected $_limit;
  protected $_offset;

  public function setLimit($limit)
  {
    $this->_limit = $limit;
    return $this;
  }

  public function getLimit()
  {
    return (int)$this->_limit;
  }

  public function setOffset($offset)
  {
    $this->_offset = $offset;
    return $this;
  }

  public function getOffset()
  {
    return (int)$this->_offset;
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
