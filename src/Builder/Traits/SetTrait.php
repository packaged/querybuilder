<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\SetClause;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Statement\IStatement;

trait SetTrait
{
  public function set($field, $value)
  {
    /**
     * @var $this  IStatement
     * @var $set   SetClause
     */
    $set = $this->getClause('SET');
    if($set === null)
    {
      $set = new SetClause();
      $this->addClause($set);
    }

    $set->addPredicate(EqualPredicate::create($field, $value)->forceOperator());

    return $this;
  }
}
