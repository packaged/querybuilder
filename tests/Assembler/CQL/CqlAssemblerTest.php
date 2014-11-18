<?php
namespace Packaged\Tests\QueryBuilder\Assembler\CQL;

use Packaged\QueryBuilder\Assembler\CQL\CqlAssembler;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\BetweenPredicate;

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
}
