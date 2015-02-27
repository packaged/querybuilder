<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\DuplicateKeyClause;
use Packaged\QueryBuilder\Clause\InsertClause;
use Packaged\QueryBuilder\Clause\ValuesClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Statement\IStatement;

trait InsertTrait
{
  public function insertInto($table, ...$fields)
  {

    /**
     * @var $this     IStatement
     */
    $clause = new InsertClause();
    $this->addClause($clause);
    $clause->setTable($table);

    foreach($fields as $field)
    {
      if(!($field instanceof FieldExpression))
      {
        $field = FieldExpression::create($field);
      }
      $clause->addField($field);
    }
    return $this;
  }

  public function values(...$values)
  {
    /**
     * @var $this     IStatement
     * @var $clause   ValuesClause
     */
    $clause = new ValuesClause();
    $this->addClause($clause);

    foreach($values as $value)
    {
      if(!($value instanceof ValueExpression))
      {
        $value = ValueExpression::create($value);
      }
      $clause->addExpression($value);
    }
    return $this;
  }

  /**
   * @deprecated
   *
   * @param $field
   * @param $value
   *
   * @return $this
   */
  public function onDuplicate($field, $value)
  {
    return $this->onDuplicateKeyUpdate($field, $value);
  }

  public function onDuplicateKeyUpdate($field, $value)
  {
    /**
     * @var $this     IStatement
     * @var $clause   DuplicateKeyClause
     */
    $clause = $this->getClause('ONDUPLICATEKEYUPDATE');
    if($clause === null)
    {
      $clause = new DuplicateKeyClause();
      $this->addClause($clause);
    }

    $clause->addPredicate(
      EqualPredicate::create($field, $value)->forceOperator()
    );
    return $this;
  }
}
