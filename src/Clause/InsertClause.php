<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\Helpers\Arrays;
use Packaged\QueryBuilder\Expression\FieldExpression;

class InsertClause extends AbstractTableClause
{
  protected $_fields = [];

  public function addField(FieldExpression $field)
  {
    $this->_fields[] = $field;
    return $this;
  }

  public function setFields(array $fields)
  {
    $this->_fields = Arrays::instancesOf(
      $fields,
      '\Packaged\QueryBuilder\Expression\FieldExpression'
    );
    return $this;
  }

  public function clearFields()
  {
    $this->_fields = [];
    return $this;
  }

  public function getFields()
  {
    return $this->_fields;
  }

  public function hasFields()
  {
    return !empty($this->_fields);
  }

  /**
   * @return string
   */
  public function getAction()
  {
    return 'INSERT INTO';
  }
}
