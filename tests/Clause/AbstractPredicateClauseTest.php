<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Clause\AbstractPredicateClause;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Predicate\NotEqualPredicate;

class AbstractPredicateClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testGettersAndSetters()
  {
    $clause = new FinalAbstractPredicateClause();
    $eq     = new EqualPredicate();
    $neq    = new NotEqualPredicate();

    $this->assertFalse($clause->hasPredicates());
    $clause->addPredicate($eq);
    $this->assertTrue($clause->hasPredicates());
    $this->assertSame([$eq], $clause->getPredicates());

    $clause->clearPredicates();
    $clause->setPredicates([$eq, $neq]);
    $this->assertTrue($clause->hasPredicates());

    $clause->clearPredicates();
    $this->assertFalse($clause->hasPredicates());

    $this->setExpectedException("InvalidArgumentException");
    $clause->setPredicates([$eq, $neq, 'abc']);
  }

  public function testAssemble()
  {
    $clause = new FinalAbstractPredicateClause();
    $eq     = new EqualPredicate();
    $string = (new StringExpression())->setValue('val');
    $eq->setField('one')->setExpression($string);
    $neq = new NotEqualPredicate();
    $neq->setField('two')->setExpression($string);

    $clause->addPredicate($eq);
    $this->assertEquals('T one = "val"', $clause->assemble());

    $clause->clearPredicates();
    $clause->setPredicates([$eq, $neq]);
    $this->assertEquals(
      'T one = "val" AND two <> "val"',
      $clause->assemble()
    );
  }
}

class FinalAbstractPredicateClause extends AbstractPredicateClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'T';
  }
}