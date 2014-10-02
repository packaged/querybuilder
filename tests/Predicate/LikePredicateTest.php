<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Predicate\LikePredicate;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;

class LikePredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new LikePredicate();
    $predicate->setField('field');
    $this->assertEquals('field LIKE NULL', $predicate->assemble());
    $predicate->setExpression((new NumericExpression())->setValue(1));
    $this->assertEquals('field LIKE 1', $predicate->assemble());
    $predicate->setExpression((new NumericExpression())->setValue('1'));
    $this->assertEquals('field LIKE 1', $predicate->assemble());
    $predicate->setExpression((new StringExpression())->setValue('abc'));
    $this->assertEquals('field LIKE "abc"', $predicate->assemble());
    $predicate->setExpression((new StringExpression())->setValue('abc%'));
    $this->assertEquals('field LIKE "abc%"', $predicate->assemble());
    $predicate->setExpression((new StringExpression())->setValue('%abc%'));
    $this->assertEquals('field LIKE "%abc%"', $predicate->assemble());
    $predicate->setExpression((new StringExpression())->setValue('%abc'));
    $this->assertEquals('field LIKE "%abc"', $predicate->assemble());
    $predicate->setExpression((new StringExpression())->setValue('a%bc'));
    $this->assertEquals('field LIKE "a%bc"', $predicate->assemble());
  }
}
