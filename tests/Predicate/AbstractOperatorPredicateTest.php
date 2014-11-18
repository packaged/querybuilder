<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Assembler\Segments\PredicateAssembler;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\AbstractOperatorPredicate;
use Packaged\QueryBuilder\Predicate\IPredicate;

class AbstractOperatorPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new FinalAbstractOperatorPredicateTest();
    $predicate->setField('field');
    $this->assertEquals('field T NULL', QueryAssembler::stringify($predicate));
    $predicate->setExpression((new NumericExpression())->setValue(1));
    $this->assertEquals('field T 1', QueryAssembler::stringify($predicate));
    $predicate->setExpression((new NumericExpression())->setValue('1'));
    $this->assertEquals('field T 1', QueryAssembler::stringify($predicate));
    $predicate->setExpression((new StringExpression())->setValue('abc'));
    $this->assertEquals('field T "abc"', QueryAssembler::stringify($predicate));
  }

  public function testGettersAndSetters()
  {
    $predicate = new FinalAbstractOperatorPredicateTest();
    $predicate->setExpression((new NumericExpression())->setValue(1));

    $predicate->setField('test');
    $this->assertEquals(
      FieldExpression::create('test'),
      $predicate->getField()
    );

    $this->assertEquals(
      (new NumericExpression())->setValue(1),
      $predicate->getExpression()
    );
  }

  /**
   * @expectedException \RuntimeException
   * @expectedExceptionMessage Unsupported segment
   */
  public function testUnknown()
  {
    $assembler = new PredicateAssembler(new UnknownPredicate());
    $assembler->assemble();
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

class UnknownPredicate implements IPredicate
{
}