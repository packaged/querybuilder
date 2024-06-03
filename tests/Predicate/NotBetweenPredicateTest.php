<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\NotBetweenPredicate;

class NotBetweenPredicateTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $predicate = new NotBetweenPredicate();
    $predicate->setField('field');
    $this->assertEquals(
      'field NOT BETWEEN NULL AND NULL',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setValues(
      (new NumericExpression())->setValue(1),
      (new NumericExpression())->setValue(5)
    );
    $this->assertEquals(
      'field NOT BETWEEN 1 AND 5',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setValues(
      (new NumericExpression())->setValue('1'),
      (new NumericExpression())->setValue('5')
    );
    $this->assertEquals(
      'field NOT BETWEEN 1 AND 5',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setValues(
      (new StringExpression())->setValue('abc'),
      (new StringExpression())->setValue('def')
    );
    $this->assertEquals(
      'field NOT BETWEEN "abc" AND "def"',
      QueryAssembler::stringify($predicate)
    );

    $predicate = NotBetweenPredicate::create('field', 123, 456);
    $this->assertEquals(
      'field NOT BETWEEN 123 AND 456',
      QueryAssembler::stringify($predicate)
    );

    $predicate = NotBetweenPredicate::create('field', 'abc', 'def');
    $this->assertEquals(
      'field NOT BETWEEN "abc" AND "def"',
      QueryAssembler::stringify($predicate)
    );
  }
}
