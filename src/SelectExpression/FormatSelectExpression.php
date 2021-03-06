<?php
namespace Packaged\QueryBuilder\SelectExpression;

class FormatSelectExpression extends FunctionSelectExpression
{
  protected $_precision = 0;

  public function setPrecision($precision = 0)
  {
    $this->_precision = $precision;
    return $this;
  }

  public function getPrecision()
  {
    return $this->_precision;
  }

  public function hasPrecision()
  {
    return $this->_precision > 0;
  }

  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'FORMAT';
  }

  /**
   * @param             $field
   * @param int         $precision
   * @param null|string $alias
   *
   * @return static
   */
  public static function create($field, $precision = 2, $alias = null)
  {
    $expression = parent::createWithAlias($field, $alias);
    /**
     * @var $expression static
     */
    $expression->setPrecision($precision);
    return $expression;
  }
}
