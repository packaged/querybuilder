<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Predicate\BetweenPredicate;

class BetweenPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new BetweenPredicate();
    $predicate->setField('field');
    $this->assertEquals('field BETWEEN 0 AND 0', $predicate->assemble());
    $predicate->setValues(1, 5);
    $this->assertEquals('field BETWEEN 1 AND 5', $predicate->assemble());
    $predicate->setValues('1', '5');
    $this->assertEquals('field BETWEEN 1 AND 5', $predicate->assemble());
    $predicate->setValues('abc', 'def');
    $this->assertEquals(
      'field BETWEEN \'abc\' AND \'def\'',
      $predicate->assemble()
    );
  }

  public function testGettersAndSetters()
  {
    $predicate = new BetweenPredicate();
    $predicate->setValues(1, 5);
    $this->assertEquals([1, 5], $predicate->getRangeValues());
    $this->assertEquals(1, $predicate->getRangeStart());
    $this->assertEquals(5, $predicate->getRangeEnd());
    $predicate->setField('test');
    $this->assertEquals('test', $predicate->getField());
  }
}
