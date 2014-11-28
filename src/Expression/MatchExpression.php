<?php
namespace Packaged\QueryBuilder\Expression;

class MatchExpression implements IExpression
{
  protected $_matchFields = [];
  protected $_value;

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
