<?php
namespace Packaged\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Expression\IExpression;
use Packaged\QueryBuilder\Expression\Like\CustomLikeExpression;

class LikePredicate extends AbstractOperatorPredicate
{
  protected $_binary = false;

  /**
   * Operator e.g. =, >= >
   *
   * @return string
   */
  public function getOperator()
  {
    if($this->getBinary())
    {
      return 'LIKE BINARY';
    }
    return 'LIKE';
  }

  /**
   * @param bool $binary
   *
   * @return $this
   */
  public function setBinary($binary)
  {
    $this->_binary = (bool)$binary;
    return $this;
  }

  public function getBinary()
  {
    return $this->_binary;
  }

  public function setExpression(IExpression $value)
  {
    if(!($value instanceof CustomLikeExpression))
    {
      throw new \Exception('Invalid Expression Type');
    }
    $this->_value = $value;
    return $this;
  }

  public static function create($field, $value)
  {
    if(is_scalar($value))
    {
      $value = CustomLikeExpression::create($value);
    }
    return parent::create($field, $value);
  }
}
