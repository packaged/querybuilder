<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\WhereClause;
use Packaged\QueryBuilder\Predicate\OrPredicateSet;
use Packaged\QueryBuilder\Predicate\PredicateSet;
use Packaged\QueryBuilder\Statement\IStatement;

trait WhereTrait
{
  public function where()
  {
    /**
     * @var $this IStatement
     */
    $where = WhereClause::create(func_get_args());
    $this->addClause($where);
    return $this;
  }

  public function orWhere()
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

    $newPredicates = WhereClause::buildPredicates(func_get_args());
    if(count($newPredicates) === 1)
    {
      $newSet = head($newPredicates);
    }
    else
    {
      $newSet = new PredicateSet();
      $newSet->setPredicates($newPredicates);
    }

    $finalSet = new OrPredicateSet();
    $finalSet->addPredicate($currentSet);
    $finalSet->addPredicate($newSet);

    $where->clearPredicates();
    $where->addPredicate($finalSet);
    $this->addClause($where);
    return $this;
  }
}
