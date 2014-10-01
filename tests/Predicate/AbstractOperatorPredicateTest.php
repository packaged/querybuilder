<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Predicate\AbstractOperatorPredicate;

class AbstractOperatorPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new FinalAbstractOperatorPredicateTest();
    $predicate->setField('field');
    $this->assertEquals('field T \'\'', $predicate->assemble());
    $predicate->setValue(1);
    $this->assertEquals('field T 1', $predicate->assemble());
    $predicate->setValue('1');
    $this->assertEquals('field T 1', $predicate->assemble());
    $predicate->setValue('abc');
    $this->assertEquals('field T \'abc\'', $predicate->assemble());
  }

  public function testGettersAndSetters()
  {
    $predicate = new FinalAbstractOperatorPredicateTest();
    $predicate->setValue(1);
    $predicate->setField('test');
    $this->assertEquals('test', $predicate->getField());
    $this->assertEquals(1, $predicate->getValue());
  }
}

class FinalAbstractOperatorPredicateTest extends AbstractOperatorPredicate
{
  /**
   * Operator e.g. =, >= >
   * @return string
   */
  public function getOperator()
  {
    return 'T';
  }
}
