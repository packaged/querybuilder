<?php
namespace Packaged\QueryBuilder\Expression;

class MatchExpression implements IExpression
{
  const NO_MODIFIER = 0;
  const BOOLEAN_MODE = 1;
  const WITH_QUERY_EXPANSION = 2;

  protected $_matchFields = [];
  protected $_value;
  protected $_searchModifier = self::NO_MODIFIER;

  public function addField(FieldExpression $field)
  {
    $this->_matchFields[] = $field;
    return $this;
  }

  public function getFields()
  {
    return $this->_matchFields;
  }

  public function setValue($value)
  {
    $this->_value = $value;
    return $this;
  }

  public function getValue()
  {
    return $this->_value;
  }

  /**
   * @param int $modifier
   *
   * @return $this
   */
  public function setSearchModifier($modifier)
  {
    $this->_searchModifier = $modifier;
    return $this;
  }

  /**
   * Get search modifier type
   * @return int
   */
  public function getSearchModifier()
  {
    return $this->_searchModifier;
  }

  /**
   * @param FieldExpression $field
   * @param IExpression     $value
   *
   * @return static
   */
  public static function create(FieldExpression $field, IExpression $value)
  {
    $expression = new static;
    $expression->addField($field);
    $expression->setValue($value);
    return $expression;
  }
}
