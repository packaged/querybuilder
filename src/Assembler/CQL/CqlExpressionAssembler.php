<?php
namespace Packaged\QueryBuilder\Assembler\CQL;

use Packaged\QueryBuilder\Assembler\Segments\ExpressionAssembler;
use Packaged\QueryBuilder\Expression\StringExpression;

class CqlExpressionAssembler extends ExpressionAssembler
{
  public function assembleStringExpression(StringExpression $expr)
  {
    return '\'' . $expr->getValue() . '\'';
  }
}
