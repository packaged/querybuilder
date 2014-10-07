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
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    $compiled = [];
    foreach($this->_getOrder() as $order)
    {
      if(isset($this->_clauses[$order]))
      {
        if(is_array($this->_clauses[$order]))
        {
          $compiled[] = implode(
            $this->_getGlue($order),
            mpull($this->_clauses[$order], 'assemble')
          );
        }
        else
        {
          $compiled[] = $this->_clauses[$order]->assemble();
        }
      }
    }
    return implode(' ', $compiled);
  }

  protected function _getGlue($order)
  {
    if($order === 'VALUES')
    {
      return ', ';
    }
    return ' ';
  }
}
