<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Expression\FieldExpression;

abstract class AbstractFieldClause implements ClauseInterface
{
  /**
   * @var FieldExpression[]
   */
  protected $_fields = [];

  public function addField(FieldExpression $field)
  {
    $this->_fields[] = $field;
  }

  public function clearFields()
  {
    $this->_fields = [];
  }

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    return $this->getAction() . ' '
    . implode(', ', mpull($this->_fields, 'assemble'));
  }

  /**
   * @return bool
   */
  public function allowMultiple()
  {
    return false;
  }
}
