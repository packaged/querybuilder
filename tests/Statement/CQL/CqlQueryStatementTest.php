<?php
namespace Packaged\Tests\QueryBuilder\Statement\CQL;

use Packaged\QueryBuilder\Assembler\CQL\CqlAssembler;
use Packaged\QueryBuilder\Builder\CQL\CqlQueryBuilder;
use Packaged\QueryBuilder\Clause\CQL\AllowFilteringClause;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;

class CqlQueryStatementTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $statement = CqlQueryBuilder::select(AllSelectExpression::create());
    $statement->addClause(new AllowFilteringClause());
    $this->assertEquals(
      'SELECT * ALLOW FILTERING',
      CqlAssembler::stringify($statement)
    );
  }
}
