<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

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
    $this->assertEquals('field NOT IN NULL', $predicate->assemble());
    $predicate->setExpression((new NumericExpression())->setValue(1));
    $this->assertEquals('field NOT IN 1', $predicate->assemble());
    $predicate->setExpression(ArrayExpression::create(['1', 2, 3]));
    $this->assertEquals('field NOT IN ("1","2","3")', $predicate->assemble());
    $predicate->setExpression(ValueExpression::create([4]));
    $this->assertEquals('field NOT IN ("4")', $predicate->assemble());
  }
}
