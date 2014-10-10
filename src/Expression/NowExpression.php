<?php
namespace Packaged\QueryBuilder\Expression;

class NowExpression implements IExpression
{
  public function getFunction()
  {
    return 'NOW()';
  }
}
