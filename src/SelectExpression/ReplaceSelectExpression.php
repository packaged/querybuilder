<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Expression\IExpression;
use Packaged\QueryBuilder\Expression\StringExpression;

class ReplaceSelectExpression extends FunctionSelectExpression
{
  protected $_searchString = null;
  protected $_replaceString = null;

  public function setSearchString($string)
  {
    $this->_searchString = $string;
    return $this;
  }

  public function getSearchString()
  {
    return $this->_searchString instanceof IExpression
      ? $this->_searchString : StringExpression::create($this->_searchString);
  }

  public function setReplaceString($side)
  {
    $this->_replaceString = $side;
    return $this;
  }

  public function getReplaceString()
  {
    return $this->_replaceString instanceof IExpression
      ? $this->_replaceString : StringExpression::create($this->_replaceString);
  }

  /**
   * Aggregate function name e.g. SUM
   *
   * @return string
   */
  public function getFunctionName()
  {
    return 'REPLACE';
  }

  public static function create(
    $field, $search = null, $replace = null, $alias = null
  )
  {
    $expression = parent::createWithAlias($field, $alias);
    /**
     * @var $expression static
     */
    $expression->setSearchString($search);
    $expression->setReplaceString($replace);
    return $expression;
  }
}
