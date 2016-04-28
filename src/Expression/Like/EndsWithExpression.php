<?php
namespace Packaged\QueryBuilder\Expression\Like;

class EndsWithExpression extends CustomLikeExpression
{
  public function getValue()
  {
    return '%' . parent::getValue();
  }
}
