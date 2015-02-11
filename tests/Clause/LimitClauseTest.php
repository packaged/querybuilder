<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Clause\LimitClause;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;

class LimitClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new LimitClause();
    $clause->setLimit(10);
    $this->assertEquals('LIMIT 10', QueryAssembler::stringify($clause));
    $clause->setOffset(5);
    $this->assertEquals('LIMIT 5,10', QueryAssembler::stringify($clause));

    $stmt = QueryBuilder::select(AllSelectExpression::create())
      ->limit(3);
    $assembler = new QueryAssembler($stmt);
    $this->assertEquals('SELECT * LIMIT ?', $assembler->getQuery());
    $this->assertEquals([3], $assembler->getParameters());
  }
}
