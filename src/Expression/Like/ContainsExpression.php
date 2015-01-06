<?php
namespace Packaged\QueryBuilder\Expression\Like;

class ContainsExpression extends CustomLikeExpression
{
  public function getValue()
  {
    return '%' . parent::getValue() . '%';
  }
}
