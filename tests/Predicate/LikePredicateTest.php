<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Predicate\LikePredicate;

class LikePredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new LikePredicate();
    $predicate->setField('field');
    $this->assertEquals('field LIKE \'\'', $predicate->assemble());
    $predicate->setValue(1);
    $this->assertEquals('field LIKE 1', $predicate->assemble());
    $predicate->setValue('1');
    $this->assertEquals('field LIKE 1', $predicate->assemble());
    $predicate->setValue('abc');
    $this->assertEquals('field LIKE \'abc\'', $predicate->assemble());
    $predicate->setValue('abc%');
    $this->assertEquals('field LIKE \'abc%\'', $predicate->assemble());
    $predicate->setValue('%abc%');
    $this->assertEquals('field LIKE \'%abc%\'', $predicate->assemble());
    $predicate->setValue('%abc');
    $this->assertEquals('field LIKE \'%abc\'', $predicate->assemble());
    $predicate->setValue('a%bc');
    $this->assertEquals('field LIKE \'a%bc\'', $predicate->assemble());
  }
}
