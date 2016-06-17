<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Clause\JoinClause;
use Packaged\QueryBuilder\Clause\LeftOuterJoinClause;
use Packaged\QueryBuilder\Clause\RightOuterJoinClause;
use Packaged\QueryBuilder\Clause\WhereClause;
use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\SelectExpression\TableSelectExpression;
use Packaged\QueryBuilder\Statement\IStatement;

trait JoinTrait
{
  public function join($table, $sourceField, $destField = null, $where = null)
  {
    return $this->_join(
      new JoinClause(),
      $table,
      $sourceField,
      $destField,
      $where
    );
  }

  public function innerJoin(
    $table, $sourceField, $destField = null, $where = null
  )
  {
    return $this->_join(
      new JoinClause(),
      $table,
      $sourceField,
      $destField,
      $where
    );
  }

  public function leftOuterJoin(
    $table, $sourceField, $destField = null, $where = null
  )
  {
    return $this->_join(
      new LeftOuterJoinClause(),
      $table,
      $sourceField,
      $destField,
      $where
    );
  }

  public function rightOuterJoin(
    $table, $sourceField, $destField = null, $where = null
  )
  {
    return $this->_join(
      new RightOuterJoinClause(),
      $table,
      $sourceField,
      $destField,
      $where
    );
  }

  private function _join(
    JoinClause $join, $table, $sourceField, $destField = null, $where = null
  )
  {
    /**
     * @var $this IStatement
     */
    if($destField === null)
    {
      $destField = $sourceField;
    }

    $from = $this->getClause('FROM');
    if($from instanceof FromClause)
    {
      $sourceTable = $from->getTable();
      if($sourceTable instanceof TableSelectExpression)
      {
        /** @var TableSelectExpression $sourceTable */
        $sourceTable = $sourceTable->getAlias();
      }
      else if($sourceTable instanceof TableExpression)
      {
        /** @var TableExpression $sourceTable */
        $sourceTable = $sourceTable->getTableName();
      }
    }
    else
    {
      throw new \RuntimeException(
        "Unable to join on a statement without a from clause being specified"
      );
    }

    $join->setTableName($table);
    $join->setDestinationField($table, $destField);
    $join->setSourceField($sourceTable, $sourceField);

    if($where !== null)
    {
      $join->setPredicates(WhereClause::buildPredicates($where, $table));
    }

    $this->addClause($join);
    return $this;
  }

  public function joinWithPredicates($table, ...$predicates)
  {
    if(empty($predicates))
    {
      throw new \RuntimeException('No predicates specified for join');
    }

    $join = new JoinClause();
    $join->setTableName($table);
    $join->setPredicates(WhereClause::buildPredicates($predicates, $table));

    $this->addClause($join);
    return $this;
  }
}
