<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\Helpers\Arrays;

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

  public function addField($field, $order = null)
  {
    parent::addField($field);
    $this->_order[] = $order;
  }

  public function clearFields()
  {
    parent::clearFields();
    $this->_order = [];
  }

  public function getOrder($field, $default = 'ASC')
  {
    return Arrays::value(
      $this->_order,
      array_search($field, $this->_fields),
      $default
    );
  }
}
