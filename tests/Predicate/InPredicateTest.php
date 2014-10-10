<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\ArrayExpression;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Predicate\InPredicate;

class InPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new InPredicate();
    $predicate->setField('field');
    $this->assertEquals('field IN NULL', QueryAssembler::stringify($predicate));
    $predicate->setExpression((new NumericExpression())->setValue(1));
    $this->assertEquals('field IN 1', QueryAssembler::stringify($predicate));
    $predicate->setExpression(ArrayExpression::create(['1', 2, 3]));
    $this->assertEquals(
      'field IN ("1","2","3")',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(ValueExpression::create([4]));
    $this->assertEquals(
      'field IN ("4")',
      QueryAssembler::stringify($predicate)
    );
  }
}
