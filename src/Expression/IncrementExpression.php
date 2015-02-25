<?php
namespace Packaged\QueryBuilder\Expression;

class IncrementExpression extends AdditionExpression
{
  protected $_defaultValue = 0;

  public function setIncrementValue($increment = 1)
  {
    $this->setExpression(NumericExpression::create($increment));
    return $this;
  }
}
