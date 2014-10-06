<?php
namespace Packaged\QueryBuilder\Clause;

class LimitClause implements ClauseInterface
{
  protected $_limit;
  protected $_offset;

  public function setLimit($limit)
  {
    $this->_limit = $limit;
    return $this;
  }

  public function setOffset($offset)
  {
    $this->_offset = $offset;
    return $this;
  }

  /**
   * @return string
   */
  public function getAction()
  {
    return 'LIMIT';
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return $this->getAction() . ' '
    . ($this->_offset !== null ? (int)$this->_offset . ',' : '')
    . (int)$this->_limit;
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return false;
  }
}
