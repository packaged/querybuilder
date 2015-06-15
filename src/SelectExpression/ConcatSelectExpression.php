<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\Helpers\Strings;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\SelectExpression\Traits\AliasTrait;

/**
 * Fields to concat together should be specified individually into the
 * contructor and strings should be quoted before pushing through
 */
class ConcatSelectExpression implements ISelectExpression
{
  use AliasTrait;

  protected $_properties;

  public function setProperties(...$properties)
  {
    return $this->setPropertyArray($properties);
  }

  public function setPropertyArray($properties)
  {
    $this->_properties = [];
    foreach($properties as $property)
    {
      if(Strings::containsAny($property, ['"', "'", ')']))
      {
        $this->_properties[] = $property;
      }
      else
      {
        $this->_properties[] = FieldExpression::create($property);
      }
    }
    return $this;
  }

  public function getProperties()
  {
    return $this->_properties;
  }

  public static function create(...$properties)
  {
    $expression = new static;
    $expression->_properties = $properties;
    return $expression;
  }
}
