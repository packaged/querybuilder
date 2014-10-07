<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Clause\JoinClause;
use Packaged\QueryBuilder\Clause\WhereClause;
use Packaged\QueryBuilder\Statement\IStatement;

trait JoinTrait
{
  public function join($table, $sourceField, $destField = null, $where = null)
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
      $sourceTable = $from->getTableName();
    }
    else
    {
      throw new \RuntimeException(
        "Unable to join on a statement without a from clause being specified"
      );
    }

    $join = new JoinClause();
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
}
