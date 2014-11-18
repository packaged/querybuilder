<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Predicate\NotEqualPredicate;
use Packaged\QueryBuilder\Predicate\PredicateSet;

class PredicateSetTest extends \PHPUnit_Framework_TestCase
{
  public function testGettersAndSetters()
  {
    $set = new PredicateSet();
    $eq  = new EqualPredicate();
    $neq = new NotEqualPredicate();

    $this->assertFalse($set->hasPredicates());
    $set->addPredicate($eq);
    $this->assertTrue($set->hasPredicates());
    $this->assertSame([$eq], $set->getPredicates());

    $set->clearPredicates();
    $set->setPredicates([$eq, $neq]);
    $this->assertTrue($set->hasPredicates());

    $set->clearPredicates();
    $this->assertFalse($set->hasPredicates());

    $this->setExpectedException("InvalidArgumentException");
    $set->setPredicates([$eq, $neq, 'abc']);
  }

  public function testAssemble()
  {
    $set = new PredicateSet();
    $this->assertEquals('', QueryAssembler::stringify($set));

    $eq = new EqualPredicate();
    $eq->setField("first")->setExpression(ValueExpression::create('val1'));
    $neq = new NotEqualPredicate();
    $neq->setField("second")->setExpression(ValueExpression::create('val1'));

    $set->addPredicate($eq);
    $set->addPredicate($neq);

    $this->assertEquals(
      '(first = "val1" AND second <> "val1")',
      QueryAssembler::stringify($set)
    );
  }
}
