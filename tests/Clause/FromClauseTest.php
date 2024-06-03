<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\SelectExpression\CountSelectExpression;
use Packaged\QueryBuilder\SelectExpression\SubQuerySelectExpression;

class FromClauseTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $clause = new FromClause();
    $clause->setTable('tester');
    $this->assertEquals('FROM tester', QueryAssembler::stringify($clause));
  }

  public function testSubquery()
  {
    $subQuery = SubQuerySelectExpression::create(
      QueryBuilder::select('myField')->from('myTable')->limitWithOffset(5, 10),
      '_'
    );
    $stmt = QueryBuilder::select(CountSelectExpression::create())
      ->from($subQuery);
    $this->assertEquals(
      'SELECT COUNT(*) FROM (SELECT myField FROM myTable LIMIT 5,10) AS _',
      QueryAssembler::stringify($stmt)
    );
  }
}
