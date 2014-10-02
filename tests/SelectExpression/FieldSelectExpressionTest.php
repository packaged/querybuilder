<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;

class FieldSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new FieldSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('fieldname', $selector->assemble());
    $selector->setAlias('new_name');
    $this->assertEquals('fieldname AS new_name', $selector->assemble());
  }

  public function testSettersAndGetters()
  {
    $selector = new FieldSelectExpression();
    $selector->setField('new_field');
    $this->assertEquals('new_field', $selector->getField());
    $selector->setAlias('alias');
    $this->assertEquals('alias', $selector->getAlias());
  }

  public function testStatics()
  {
    $this->assertEquals(
      'fieldname',
      FieldSelectExpression::create('fieldname')->assemble()
    );
    $this->assertEquals(
      'fieldname AS new_name',
      FieldSelectExpression::createWithAlias('fieldname', 'new_name')->assemble(
      )
    );
  }
}
