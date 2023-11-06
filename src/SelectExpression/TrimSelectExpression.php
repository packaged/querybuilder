<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Expression\IExpression;
use Packaged\QueryBuilder\Expression\StringExpression;

class TrimSelectExpression extends FunctionSelectExpression
{
  protected $_string = null;
  protected $_side = null;

  public function setString($string)
  {
    $this->_string = $string;
    return $this;
  }

  public function getString()
  {
    return $this->_string instanceof IExpression
      ? $this->_string : StringExpression::create($this->_string);
  }

  public function hasString()
  {
    return $this->_string !== null;
  }

  public function setSide($side)
  {
    $side = strtoupper($side ?? '');
    if(in_array($side, ['LEADING', 'TRAILING', 'BOTH']))
    {
      $this->_side = $side;
    }
    return $this;
  }

  public function getSide()
  {
    return $this->_side;
  }

  public function hasSide()
  {
    return $this->_side !== null;
  }

  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'TRIM';
  }

  public static function create(
    $field, $string = null, $side = null, $alias = null
  )
  {
    $expression = parent::createWithAlias($field, $alias);
    /**
     * @var $expression static
     */
    $expression->setString($string);
    $expression->setSide($side);
    return $expression;
  }
}
