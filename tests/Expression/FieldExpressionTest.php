<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Expression\FieldExpression;

class FieldExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new FieldExpression();
    $expression->setField('new_field');
    $this->assertEquals('new_field', $expression->assemble());
  }

  public function testSettersAndGetters()
  {
    $expression = new FieldExpression();
    $expression->setField('new_field');
    $this->assertEquals('new_field', $expression->getField());
  }
}
