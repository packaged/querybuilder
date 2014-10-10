<?php
namespace Packaged\QueryBuilder\Statement;

use Packaged\QueryBuilder\Clause\IClause;

abstract class AbstractStatement implements IStatement
{
  /**
   * @var IClause[]|array[]
   */
  protected $_clauses;

  public function addClause(IClause $clause)
  {
    $key = $this->_makeKey($clause->getAction());
    if($clause->allowMultiple())
    {
      if(!isset($this->_clauses[$key]))
      {
        $this->_clauses[$key] = [$clause];
      }
      else
      {
        $this->_clauses[$key][] = $clause;
      }
    }
    else
    {
      $this->_clauses[$key] = $clause;
    }
    return $this;
  }

  protected function _makeKey($action)
  {
    return str_replace(' ', '', $action);
  }

  /**
   * @param $action
   *
   * @return null|IClause
   */
  public function getClause($action)
  {
    $key = $this->_makeKey($action);
    return isset($this->_clauses[$key]) ? $this->_clauses[$key] : null;
  }

  abstract protected function _getOrder();

  /**
   * @return IStatementSegment[]
   */
  public function getSegments()
  {
    $ordered = [];
    foreach($this->_getOrder() as $order)
    {
      if(isset($this->_clauses[$order]))
      {
        $ordered[$order] = $this->_clauses[$order];
      }
    }
    return $ordered;
  }
}
