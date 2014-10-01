<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Predicate\LessThanPredicate;

class LessThanPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new LessThanPredicate();
    $predicate->setField('field');
    $this->assertEquals('field < \'\'', $predicate->assemble());
    $predicate->setValue(1);
    $this->assertEquals('field < 1', $predicate->assemble());
    $predicate->setValue('1');
    $this->assertEquals('field < 1', $predicate->assemble());
    $predicate->setValue('abc');
    $this->assertEquals('field < \'abc\'', $predicate->assemble());
  }
}
