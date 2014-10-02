<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;
use Packaged\QueryBuilder\SelectExpression\SubQuerySelectExpression;
use Packaged\QueryBuilder\Statement\QueryStatement;

class SubQuerySelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $statement = new QueryStatement();
    $select    = (new SelectClause())->addExpression(new AllSelectExpression());
    $statement->addClause($select);
    $from = (new FromClause())->setTableName('tbl');
    $statement->addClause($from);

    $selector = new SubQuerySelectExpression();
    $selector->setQuery($statement, 'query');
    $this->assertEquals('(SELECT * FROM tbl) AS query', $selector->assemble());

    $selector = new SubQuerySelectExpression();
    $selector->setQuery($statement);
    $this->assertEquals(
      '(SELECT * FROM tbl) AS ' . substr(md5($statement->assemble()), 0, 6),
      $selector->assemble()
    );
  }
}
