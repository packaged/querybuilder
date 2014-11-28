<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\WhereClause;
use Packaged\QueryBuilder\Predicate\OrPredicateSet;
use Packaged\QueryBuilder\Predicate\PredicateSet;
use Packaged\QueryBuilder\Statement\IStatement;

trait WhereTrait
{
  public function where(...$expressions)
  {
    /**
     * @var $this IStatement
     */
    $where = WhereClause::create($expressions);
    $this->addClause($where);
    return $this;
  }

  public function andWhere(...$expressions)
  {
    $currentSet = $this->_getCurrentSet();
    $newSet     = $this->_getNewSet($expressions);

    $finalSet = new PredicateSet();
    $finalSet->addPredicate($currentSet);
    $finalSet->addPredicate($newSet);

    /**
     * @var $this  IStatement
     * @var $where WhereClause
     */
    $where = $this->getClause('WHERE');
    $where->clearPredicates();
    $where->addPredicate($finalSet);
    $this->addClause($where);
    return $this;
  }

  public function orWhere(...$expressions)
  {
    $currentSet = $this->_getCurrentSet();
    $newSet     = $this->_getNewSet($expressions);

    $finalSet = new OrPredicateSet();
    $finalSet->addPredicate($currentSet);
    $finalSet->addPredicate($newSet);

    /**
     * @var $this  IStatement
     * @var $where WhereClause
     */
    $where = $this->getClause('WHERE');
    $where->clearPredicates();
    $where->addPredicate($finalSet);
    $this->addClause($where);
    return $this;
  }

  private function _getCurrentSet()
  {
    /**
     * @var $this  IStatement
     * @var $where WhereClause
     */
    $where = $this->getClause('WHERE');
    if($where === null)
    {
      throw new \RuntimeException(
        "You can only use orWhere after specifying a where clause"
      );
    }

    if(count($where->getPredicates()) === 1)
    {
      $currentSet = head($where->getPredicates());
    }
    else
    {
      $currentSet = new PredicateSet();
      $currentSet->setPredicates($where->getPredicates());
    }

    return $currentSet;
  }

  private function _getNewSet(...$expressions)
  {
    $newPredicates = WhereClause::buildPredicates($expressions);
    if(count($newPredicates) === 1)
    {
      $newSet = head($newPredicates);
    }
    else
    {
      $newSet = new PredicateSet();
      $newSet->setPredicates($newPredicates);
    }
    return $newSet;
  }
}
