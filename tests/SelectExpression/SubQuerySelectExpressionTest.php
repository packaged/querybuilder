<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;
use Packaged\QueryBuilder\SelectExpression\SubQuerySelectExpression;
use Packaged\QueryBuilder\Statement\QueryStatement;

class SubQuerySelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  protected function _basicQuery()
  {
    $statement = new QueryStatement();
    $select    = (new SelectClause())->addExpression(new AllSelectExpression());
    $statement->addClause($select);
    $from = (new FromClause())->setTable('tbl');
    $statement->addClause($from);
    return $statement;
  }

  public function testAssemble()
  {
    $statement = $this->_basicQuery();

    $selector = new SubQuerySelectExpression();
    $selector->setQuery($statement, 'query');
    $this->assertEquals(
      '(SELECT * FROM tbl) AS query',
      QueryAssembler::stringify($selector)
    );

    $selector = new SubQuerySelectExpression();
    $selector->setQuery($statement);
    $this->assertEquals(
      '(SELECT * FROM tbl) AS ' . substr(
        md5(QueryAssembler::stringify($statement)),
        0,
        6
      ),
      QueryAssembler::stringify($selector)
    );
  }

  public function testStatic()
  {
    $statement = $this->_basicQuery();
    $this->assertEquals(
      '(SELECT * FROM tbl) AS query',
      QueryAssembler::stringify(
        SubQuerySelectExpression::create($statement, 'query')
      )
    );
    $this->assertEquals(
      '(SELECT * FROM tbl) AS ' . substr(
        md5(QueryAssembler::stringify($statement)),
        0,
        6
      ),
      QueryAssembler::stringify(SubQuerySelectExpression::create($statement))
    );
  }
}
