<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Predicate\LessThanOrEqualPredicate;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;

class LessThanOrEqualPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new LessThanOrEqualPredicate();
    $predicate->setField('field');
    $this->assertEquals('field <= NULL', QueryAssembler::stringify($predicate));
    $predicate->setExpression((new NumericExpression())->setValue(1));
    $this->assertEquals('field <= 1', QueryAssembler::stringify($predicate));
    $predicate->setExpression((new NumericExpression())->setValue('1'));
    $this->assertEquals('field <= 1', QueryAssembler::stringify($predicate));
    $predicate->setExpression((new StringExpression())->setValue('abc'));
    $this->assertEquals(
      'field <= "abc"',
      QueryAssembler::stringify($predicate)
    );
  }
}
