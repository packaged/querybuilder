<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Expression\FieldExpression;

class OrderByClause extends AbstractFieldClause
{
  protected $_order;

  /**
   * @return string
   */
  public function getAction()
  {
    return 'ORDER BY';
  }

  public function addField(FieldExpression $field, $order = null)
  {
    $this->_fields[]                  = $field;
    $this->_order[$field->getField()] = $order;
  }

  public function clearFields()
  {
    parent::clearFields();
    $this->_order = [];
  }

  public function getOrder($field, $default = 'ASC')
  {
    return idx($this->_order, $field, $default);
  }
}
