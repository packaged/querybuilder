<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\HavingClause;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Predicate\GreaterThanPredicate;

class HavingClauseTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $clause = new HavingClause();
    $eq     = new EqualPredicate();
    $eq->setField('one')->setExpression(
      (new StringExpression())->setValue('val')
    );
    $clause->addPredicate($eq);
    $this->assertEquals(
      'HAVING one = "val"',
      QueryAssembler::stringify($clause)
    );

    $eq = new GreaterThanPredicate();
    $eq->setField('two')->setExpression((new NumericExpression())->setValue(5));
    $clause->addPredicate($eq);
    $this->assertEquals(
      'HAVING one = "val" AND two > 5',
      QueryAssembler::stringify($clause)
    );
  }
}
