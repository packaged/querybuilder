<?php
namespace Packaged\QueryBuilder\Assembler\MySQL;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\AbstractTableClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Statement\IStatementSegment;

class MySQLAssembler extends QueryAssembler
{
  public function assembleSegment(IStatementSegment $segment)
  {
    if($segment instanceof FieldExpression)
    {
      return $this->assembleField($segment);
    }
    else if($segment instanceof AbstractTableClause)
    {
      return $this->assembleAbstractTableClause($segment);
    }

    return parent::assembleSegment($segment);
  }

  public function assembleField(FieldExpression $field)
  {
    if($field->hasTableName())
    {
      return '`' . $field->getTableName()
      . '`.`' . $field->getField() . '`';
    }
    else
    {
      return '`' . $field->getField() . '`';
    }
  }

  public function assembleAbstractTableClause(AbstractTableClause $clause)
  {
    return $clause->getAction() . ' ' . '`' . $clause->getTableName() . '`';
  }
}
