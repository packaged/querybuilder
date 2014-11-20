<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\WhereClause;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Predicate\GreaterThanPredicate;
use Packaged\QueryBuilder\Predicate\PredicateSet;

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
    $this->assertEquals(
      'WHERE one = "val"',
      QueryAssembler::stringify($clause)
    );

    $eq = new GreaterThanPredicate();
    $eq->setField('two')->setExpression((new NumericExpression())->setValue(5));
    $clause->addPredicate($eq);
    $this->assertEquals(
      'WHERE one = "val" AND two > 5',
      QueryAssembler::stringify($clause)
    );
  }

  /**
   * @param $input
   * @param $expect
   *
   * @dataProvider predicateData
   */
  public function testBuildPredicates($input, $expect)
  {
    $this->assertEquals($expect, WhereClause::buildPredicates($input));
  }

  public function predicateData()
  {
    $nameEq = (new EqualPredicate())->setField('name')
      ->setExpression(ValueExpression::create('test'));
    $set    = new PredicateSet();
    $set->addPredicate($nameEq);

    return [
      [['name' => 'test'], [$nameEq]],
      [[$nameEq], [$nameEq]],
      [['AND' => ['name' => 'test']], [$set]],
    ];
  }

  public function testNullBuilder()
  {
    $this->assertEquals(
      "WHERE name IS NULL AND description IS NOT NULL",
      QueryAssembler::stringify(
        WhereClause::create(
          ['name' => null, 'NOT' => ['description' => null]]
        )
      )
    );
  }
}
