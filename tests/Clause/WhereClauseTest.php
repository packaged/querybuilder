<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Clause\WhereClause;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Predicate\GreaterThanPredicate;

class WhereClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new WhereClause();
    $eq     = new EqualPredicate();
    $eq->setField('one')->setExpression(
      (new StringExpression())->setValue('val')
    );
    $clause->addPredicate($eq);
    $this->assertEquals('WHERE one = "val"', $clause->assemble());

    $eq = new GreaterThanPredicate();
    $eq->setField('two')->setExpression((new NumericExpression())->setValue(5));
    $clause->addPredicate($eq);
    $this->assertEquals(
      'WHERE one = "val" AND two > 5',
      $clause->assemble()
    );
  }
}
