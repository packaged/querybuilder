<?php
namespace Packaged\QueryBuilder\Assembler\CQL;

use Packaged\QueryBuilder\Assembler\Segments\ExpressionAssembler;

class CqlExpressionAssembler extends ExpressionAssembler
{
  protected function _quoteString($string)
  {
    return "'" . str_replace("'", "''", $string) . "'";
  }
}
