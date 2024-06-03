<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;

class EqualPredicateTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $predicate = new EqualPredicate();
    $predicate->setField('field');
    $this->assertEquals('field IS NULL', QueryAssembler::stringify($predicate));
    $predicate->setExpression((new NumericExpression())->setValue(1));
    $this->assertEquals('field = 1', QueryAssembler::stringify($predicate));
    $predicate->setExpression((new NumericExpression())->setValue('1'));
    $this->assertEquals('field = 1', QueryAssembler::stringify($predicate));
    $predicate->setExpression((new StringExpression())->setValue('abc'));
    $this->assertEquals('field = "abc"', QueryAssembler::stringify($predicate));

    $predicate = EqualPredicate::create('field', null);
    $this->assertEquals('field IS NULL', QueryAssembler::stringify($predicate));
    $predicate = EqualPredicate::create('field', 1);
    $this->assertEquals('field = 1', QueryAssembler::stringify($predicate));
    $predicate = EqualPredicate::create('field', '1');
    $this->assertEquals('field = "1"', QueryAssembler::stringify($predicate));
    $predicate = EqualPredicate::create('field', 'abc');
    $this->assertEquals('field = "abc"', QueryAssembler::stringify($predicate));
  }
}
