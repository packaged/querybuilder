<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;
use Packaged\QueryBuilder\SelectExpression\SubQuerySelectExpression;
use Packaged\QueryBuilder\Statement\QueryStatement;

class SubQuerySelectExpressionTest extends \PHPUnit\Framework\TestCase
{
  protected function _basicQuery()
  {
    $statement = new QueryStatement();
    $select = (new SelectClause())->addExpression(new AllSelectExpression());
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
      '(SELECT * FROM tbl) AS ' . $selector->getAlias(),
      QueryAssembler::stringify($selector)
    );

    $selector = SubQuerySelectExpression::create($statement)->setAlias(null);
    $this->assertEquals('(SELECT * FROM tbl)', QueryAssembler::stringify($selector));
  }

  public function testStatic()
  {
    $statement = $this->_basicQuery();
    $subQuery = SubQuerySelectExpression::create($statement, 'query');
    $this->assertEquals('(SELECT * FROM tbl) AS query', QueryAssembler::stringify($subQuery));

    $this->assertEquals(
      '(SELECT * FROM tbl) AS ' . $subQuery->getAlias(),
      QueryAssembler::stringify(SubQuerySelectExpression::create($statement)->setAlias('query'))
    );
  }
}
