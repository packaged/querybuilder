<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Expression\FieldExpression;

/**
 * Fields to concat together should be specified individually into the contructor
 * and strings should be quoted before pushing through
 */
class ConcatSelectExpression implements ISelectExpression
{
  protected $_alias;
  protected $_properties;

  public function setAlias($alias)
  {
    $this->_alias = $alias;
    return $this;
  }

  public function getAlias()
  {
    return $this->_alias;
  }

  public function hasAlias()
  {
    return $this->_alias !== null;
  }

  public function setProperties(...$properties)
  {
    return $this->setPropertyArray($properties);
  }

  public function setPropertyArray($properties)
  {
    $this->_properties = [];
    foreach($properties as $property)
    {
      if(contains_any($property, ['"', "'", ')']))
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
    $expression              = new static;
    $expression->_properties = $properties;
    return $expression;
  }
}
