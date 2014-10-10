<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\ArrayExpression;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Predicate\NotInPredicate;

class NotInPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new NotInPredicate();
    $predicate->setField('field');
    $this->assertEquals(
      'field NOT IN NULL',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression((new NumericExpression())->setValue(1));
    $this->assertEquals(
      'field NOT IN 1',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(ArrayExpression::create(['1', 2, 3]));
    $this->assertEquals(
      'field NOT IN ("1","2","3")',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(ValueExpression::create([4]));
    $this->assertEquals(
      'field NOT IN ("4")',
      QueryAssembler::stringify($predicate)
    );
  }
}
