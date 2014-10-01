<?php
namespace Packaged\QueryBuilder\SelectExpression;

class NowSelectExpression extends FieldSelectExpression
{
  protected function _getFieldForAssemble()
  {
    return 'NOW()';
  }
}
