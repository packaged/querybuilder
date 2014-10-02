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

  /**
   * Assemble the segment into a usable part of a query
   *
   * @return string
   */
  public function assemble()
  {
    $orders = [];
    foreach($this->_fields as $field)
    {
      $orders[] = trim(
        $field->getField() . ' '
        . idx($this->_order, $field->getField(), '')
      );
    }
    return $this->getAction() . ' ' . implode(', ', $orders);
  }
}
