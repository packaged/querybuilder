<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\SetClause;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Statement\IStatement;
use function is_array;

trait SetTrait
{
  public function set($field, $value)
  {
    /**
     * @var $this  IStatement
     */
    $set = $this->getClause('SET');
    if($set === null)
    {
      $set = new SetClause();
      $this->addClause($set);
    }

    if(is_array($value))
    {
      foreach($value as $exp)
      {
        $set->addPredicate(EqualPredicate::create($field, $exp)->forceOperator());
      }
    }
    else
    {
      $set->addPredicate(EqualPredicate::create($field, $value)->forceOperator());
    }

    return $this;
  }
}
