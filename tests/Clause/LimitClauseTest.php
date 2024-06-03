<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Clause\LimitClause;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;

class LimitClauseTest extends \PHPUnit\Framework\TestCase
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

    $stmt = QueryBuilder::select(AllSelectExpression::create())
      ->limitWithOffset(0, 3);
    $assembler = new QueryAssembler($stmt);
    $this->assertEquals('SELECT * LIMIT ?,?', $assembler->getQuery());
    $this->assertEquals([0, 3], $assembler->getParameters());

    $offset = NumericExpression::create(0);
    $limit = NumericExpression::create(3);
    $stmt = QueryBuilder::select(AllSelectExpression::create())
      ->limitWithOffset($offset, $limit);
    $assembler = new QueryAssembler($stmt);
    $this->assertEquals('SELECT * LIMIT ?,?', $assembler->getQuery());
    $this->assertEquals([0, 3], $assembler->getParameters());

    $offset->setValue(25);
    $limit->setValue(38);
    $this->assertEquals('SELECT * LIMIT ?,?', $assembler->getQuery());
    $this->assertEquals([25, 38], $assembler->getParameters());
  }
}
