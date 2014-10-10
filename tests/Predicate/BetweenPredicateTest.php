<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\BetweenPredicate;

class BetweenPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new BetweenPredicate();
    $predicate->setField('field');
    $this->assertEquals(
      'field BETWEEN NULL AND NULL',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setValues(
      (new NumericExpression())->setValue(1),
      (new NumericExpression())->setValue(5)
    );
    $this->assertEquals(
      'field BETWEEN 1 AND 5',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setValues(
      (new NumericExpression())->setValue('1'),
      (new NumericExpression())->setValue('5')
    );
    $this->assertEquals(
      'field BETWEEN 1 AND 5',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setValues(
      (new StringExpression())->setValue('abc'),
      (new StringExpression())->setValue('def')
    );
    $this->assertEquals(
      'field BETWEEN "abc" AND "def"',
      QueryAssembler::stringify($predicate)
    );
  }

  public function testGettersAndSetters()
  {
    $predicate = new BetweenPredicate();
    $predicate->setValues(
      (new NumericExpression())->setValue(1),
      (new NumericExpression())->setValue(5)
    );
    $this->assertEquals(
      [
        (new NumericExpression())->setValue(1),
        (new NumericExpression())->setValue(5)
      ],
      $predicate->getRangeValues()
    );
    $this->assertEquals(
      (new NumericExpression())->setValue(1),
      $predicate->getRangeStart()
    );
    $this->assertEquals(
      (new NumericExpression())->setValue(5),
      $predicate->getRangeEnd()
    );
    $predicate->setField('test');
    $this->assertEquals(
      FieldExpression::create('test'),
      $predicate->getField()
    );
  }
}
