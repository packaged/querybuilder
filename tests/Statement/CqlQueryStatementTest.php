<?php
namespace Packaged\Tests\QueryBuilder\Statement;

use Packaged\QueryBuilder\Assembler\CQL\CqlAssembler;
use Packaged\QueryBuilder\Clause\CQL\AllowFilteringClause;
use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;
use Packaged\QueryBuilder\Statement\CQL\CqlQueryStatement;

class CqlQueryStatementTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $statement = new CqlQueryStatement();
    $select    = new SelectClause();
    $select->addExpression(new AllSelectExpression());
    $statement->addClause($select);
    $statement->addClause(new AllowFilteringClause());
    $this->assertEquals(
      'SELECT * ALLOW FILTERING',
      CqlAssembler::stringify($statement)
    );
  }
}
