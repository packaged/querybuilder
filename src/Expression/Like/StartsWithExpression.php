<?php
namespace Packaged\QueryBuilder\Expression\Like;

class StartsWithExpression extends CustomLikeExpression
{
  public function getValue()
  {
    return '%' . parent::getValue();
  }
}
