<?php
namespace Packaged\QueryBuilder\Statement;

use Packaged\QueryBuilder\Clause\ClauseInterface;

abstract class AbstractStatement implements StatementInterface
{
  /**
   * @var ClauseInterface[]
   */
  protected $_clauses;

  public function addClause(ClauseInterface $clause)
  {
    $this->_clauses[str_replace(' ', '', $clause->getAction())] = $clause;
    return $this;
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
        $compiled[] = $this->_clauses[$order]->assemble();
      }
    }
    return implode(' ', $compiled);
  }
}
