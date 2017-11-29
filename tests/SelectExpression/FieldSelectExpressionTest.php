<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;

class FieldSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new FieldSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('fieldname', QueryAssembler::stringify($selector));
    $selector->setAlias('new_name');
    $this->assertEquals(
      'fieldname AS new_name',
      QueryAssembler::stringify($selector)
    );
  }

  public function testSettersAndGetters()
  {
    $selector = new FieldSelectExpression();
    $selector->setField('new_field');
    $this->assertEquals(
      FieldExpression::create('new_field'),
      $selector->getField()
    );
    $selector->setAlias('alias');
    $this->assertEquals('alias', $selector->getAlias());

    $field = FieldExpression::create('testfield');
    $selector->setField($field);
    $this->assertSame($field, $selector->getField());
  }

  public function testStatics()
  {
    $this->assertEquals(
      'fieldname',
      QueryAssembler::stringify(FieldSelectExpression::create('fieldname'))
    );
    $this->assertEquals(
      'fieldname AS new_name',
      QueryAssembler::stringify(
        FieldSelectExpression::createWithAlias('fieldname', 'new_name')
      )
    );
  }

  public function testCollation()
  {
    $expression = FieldSelectExpression::create('fieldname');
    $expression->setCollation('utf8mb4_unicode_ci');
    $this->assertEquals('fieldname COLLATE utf8mb4_unicode_ci', QueryAssembler::stringify($expression));

    $expression = FieldSelectExpression::createWithAlias('fieldname', 'ali');
    $expression->setCollation('utf8mb4_unicode_ci');
    $this->assertEquals('fieldname COLLATE utf8mb4_unicode_ci AS ali', QueryAssembler::stringify($expression));
  }
}
