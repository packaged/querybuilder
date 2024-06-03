<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Predicate\NotEqualPredicate;
use Packaged\QueryBuilder\Predicate\PredicateSet;

class PredicateSetTest extends \PHPUnit\Framework\TestCase
{
  public function testGettersAndSetters()
  {
    $set = new PredicateSet();
    $eq = new EqualPredicate();
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

    $this->expectException("InvalidArgumentException");
    $set->setPredicates([$eq, $neq, 'abc']);
  }

  public function testAssemble()
  {
    $this->assertEquals('', QueryAssembler::stringify(PredicateSet::create()));

    $eq = new EqualPredicate();
    $eq->setField("first")->setExpression(ValueExpression::create('val1'));
    $neq = new NotEqualPredicate();
    $neq->setField("second")->setExpression(ValueExpression::create('val1'));

    $set = PredicateSet::create($eq, $neq);

    $this->assertEquals(
      '(first = "val1" AND second <> "val1")',
      QueryAssembler::stringify($set)
    );
  }
}
