<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\GreaterThanOrEqualPredicate;

class GreaterThanOrEqualPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new GreaterThanOrEqualPredicate();
    $predicate->setField('field');
    $this->assertEquals('field >= NULL', $predicate->assemble());
    $predicate->setExpression((new NumericExpression())->setValue(1));
    $this->assertEquals('field >= 1', $predicate->assemble());
    $predicate->setExpression((new NumericExpression())->setValue('1'));
    $this->assertEquals('field >= 1', $predicate->assemble());
    $predicate->setExpression((new StringExpression())->setValue('abc'));
    $this->assertEquals('field >= "abc"', $predicate->assemble());
  }
}
