<?php
namespace Packaged\QueryBuilder\SelectExpression;

class NowSelectExpression extends FieldSelectExpression
{
  public function getFunction()
  {
    return 'NOW()';
  }
}
