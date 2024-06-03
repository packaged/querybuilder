<?php
namespace Packaged\QueryBuilder\Assembler\MySQL;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\MatchExpression;
use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\SelectExpression\MatchSelectExpression;

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
        . '.' . $this->escapeField($field->getField());
    }
    else
    {
      return $this->escapeField($field->getField());
    }
  }

  public function assembleTableExpression(TableExpression $expr)
  {
    if($expr->getDatabase())
    {
      return $this->escapeField($expr->getDatabase()) . '.' . $this->escapeField($expr->getTableName());
    }
    return $this->escapeField($expr->getTableName());
  }

  public function assembleMatchExpression(MatchExpression $expr)
  {
    $fields = [];
    foreach($expr->getFields() as $field)
    {
      $fields[] = $this->assembleSegment($field);
    }

    switch($expr->getSearchModifier())
    {
      case MatchExpression::BOOLEAN_MODE:
        $modifier = ' IN BOOLEAN MODE';
        break;
      case MatchExpression::WITH_QUERY_EXPANSION:
        $modifier = ' WITH QUERY EXPANSION';
        break;
      default:
        $modifier = '';
    }

    $alias = '';
    if($expr instanceof MatchSelectExpression)
    {
      if($expr->hasAlias())
      {
        $alias = ' AS `' . $expr->getAlias() . '`';
      }
    }

    return sprintf(
      'MATCH (%s) AGAINST (%s%s)%s',
      implode(',', $fields),
      $this->assembleSegment($expr->getValue()),
      $modifier,
      $alias
    );
  }

  public function escapeField($field)
  {
    return '`' . addcslashes($field, '`') . '`';
  }
}
