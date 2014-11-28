<?php
namespace Packaged\QueryBuilder\Assembler\MySQL;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\MatchExpression;
use Packaged\QueryBuilder\Expression\TableExpression;

class MySQLAssembler extends QueryAssembler
{
  public function assembleSegment($segment)
  {
    if($segment instanceof FieldExpression)
    {
      return $this->assembleField($segment);
    }
    else if($segment instanceof TableExpression)
    {
      return $this->assembleTableExpression($segment);
    }
    else if($segment instanceof MatchExpression)
    {
      return $this->assembleMatchExpression($segment);
    }

    return parent::assembleSegment($segment);
  }

  public function assembleField(FieldExpression $field)
  {
    if($field->hasTable())
    {
      return $this->assembleTableExpression($field->getTable())
      . '.`' . $field->getField() . '`';
    }
    else
    {
      return '`' . $field->getField() . '`';
    }
  }

  public function assembleTableExpression(TableExpression $expr)
  {
    return '`' . $expr->getTableName() . '`';
  }

  public function assembleMatchExpression(MatchExpression $expr)
  {
    $fields = [];
    foreach($expr->getFields() as $field)
    {
      $fields[] = $this->assembleSegment($field);
    }
    return sprintf(
      'MATCH (%s) AGAINST (%s)',
      implode(',', $fields),
      $this->assembleSegment($expr->getValue())
    );
  }
}
