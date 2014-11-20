<?php
namespace Packaged\Tests\QueryBuilder\Assembler\CQL;

use Packaged\QueryBuilder\Assembler\CQL\CqlAssembler;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\BetweenPredicate;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;

class CqlAssemblerTest extends \PHPUnit_Framework_TestCase
{
  public function testBetween()
  {
    $predicate = new BetweenPredicate();
    $predicate->setField('field');
    $this->assertEquals(
      '("field" >= NULL AND "field" <= NULL)',
      CqlAssembler::stringify($predicate)
    );
    $predicate->setValues(
      (new NumericExpression())->setValue(1),
      (new NumericExpression())->setValue(5)
    );
    $this->assertEquals(
      '("field" >= 1 AND "field" <= 5)',
      CqlAssembler::stringify($predicate)
    );
    $predicate->setValues(
      (new NumericExpression())->setValue('1'),
      (new NumericExpression())->setValue('5')
    );
    $this->assertEquals(
      '("field" >= 1 AND "field" <= 5)',
      CqlAssembler::stringify($predicate)
    );
    $predicate->setValues(
      (new StringExpression())->setValue('abc'),
      (new StringExpression())->setValue('def')
    );
    $this->assertEquals(
      '("field" >= \'abc\' AND "field" <= \'def\')',
      CqlAssembler::stringify($predicate)
    );
  }

  public function testAllSelect()
  {
    $selector = new AllSelectExpression();
    $this->assertEquals('*', CqlAssembler::stringify($selector));
    $selector->setTable('test');
    $this->assertEquals('*', CqlAssembler::stringify($selector));
  }

  public function testTableName()
  {
    $this->assertEquals(
      '"mytable"."myfield"',
      CqlAssembler::stringify(
        FieldExpression::createWithTable('myfield', 'mytable')
      )
    );
  }
}
