<?php
namespace Packaged\QueryBuilder\Assembler\CQL;

use Packaged\QueryBuilder\Assembler\Segments\ExpressionAssembler;
use Packaged\QueryBuilder\Expression\ArrayExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;

class CqlExpressionAssembler extends ExpressionAssembler
{
  public function assembleStringExpression(StringExpression $expr)
  {
    return $this->_assemblePrepared($expr) ?: "'" . $expr->getValue() . "'";
  }

  public function assembleArrayExpression(ArrayExpression $expr)
  {
    $values = [];
    foreach($expr->getValue() as $value)
    {
      $values[] = $this->_assemblePrepared(ValueExpression::create($value))
        ?: "'" . $value . "'";
    }
    return '(' . implode(',', $values) . ')';
  }
}
