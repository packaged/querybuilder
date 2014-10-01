<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Predicate\NotEqualPredicate;

class NotEqualPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new NotEqualPredicate();
    $predicate->setField('field');
    $this->assertEquals('field IS NOT NULL', $predicate->assemble());
    $predicate->setValue(1);
    $this->assertEquals('field <> 1', $predicate->assemble());
    $predicate->setValue('1');
    $this->assertEquals('field <> 1', $predicate->assemble());
    $predicate->setValue('abc');
    $this->assertEquals('field <> \'abc\'', $predicate->assemble());
  }
}
