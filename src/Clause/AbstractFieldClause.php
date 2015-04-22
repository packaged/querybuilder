<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Expression\FieldExpression;

abstract class AbstractFieldClause implements IClause
{
  /**
   * @var FieldExpression[]
   */
  protected $_fields = [];

  public function addField($field)
  {
    if(is_scalar($field))
    {
      $field = FieldExpression::create($field);
    }

    $this->_fields[] = $field;
  }

  /**
   * @return \Packaged\QueryBuilder\Expression\FieldExpression[]
   */
  public function getFields()
  {
    return $this->_fields;
  }

  public function clearFields()
  {
    $this->_fields = [];
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return false;
  }
}
