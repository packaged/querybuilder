<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Clause\SetClause;
use Packaged\QueryBuilder\Expression\IncrementExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;

class SetClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new SetClause();
    $eq     = new EqualPredicate();
    $eq->setField('one')->setExpression(
      (new StringExpression())->setValue('val')
    );
    $clause->addPredicate($eq);
    $this->assertEquals('SET one = "val"', $clause->assemble());

    $inc = new EqualPredicate();
    $inc->setField('two')->setExpression(
      (new IncrementExpression())->setField('two')->setIncrementValue(5)
    );
    $clause->addPredicate($inc);
    $this->assertEquals(
      'SET one = "val", two = two + 5',
      $clause->assemble()
    );
  }
}
