<?php
namespace Packaged\Tests\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Builder\Traits\JoinTrait;
use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;
use Packaged\QueryBuilder\SelectExpression\TableSelectExpression;
use Packaged\QueryBuilder\Statement\AbstractStatement;

class JoinTraitTest extends \PHPUnit\Framework\TestCase
{
  public function testCreate()
  {
    $class = new FinalJoinTrait();
    $class->addClause((new FromClause())->setTable('tbl'));
    $class->join(TableExpression::create('tbl2'), 'email');
    $this->assertEquals(
      "FROM tbl INNER JOIN tbl2 ON tbl.email = tbl2.email",
      QueryAssembler::stringify($class)
    );
    $class->join('tbl3', 'user', 'user_id');
    $this->assertEquals(
      'FROM tbl INNER JOIN tbl2 ON tbl.email = tbl2.email '
      . 'INNER JOIN tbl3 ON tbl.user = tbl3.user_id',
      QueryAssembler::stringify($class)
    );
    $class->joinWithPredicates(
      TableSelectExpression::createWithAlias('tbl4', 't4'),
      EqualPredicate::create(
        FieldExpression::createWithTable('email', 'tbl2'),
        FieldExpression::createWithTable('email', 't4')
      )
    );
    $this->assertEquals(
      'FROM tbl INNER JOIN tbl2 ON tbl.email = tbl2.email '
      . 'INNER JOIN tbl3 ON tbl.user = tbl3.user_id '
      . 'INNER JOIN tbl4 AS t4 ON tbl2.email = t4.email',
      QueryAssembler::stringify($class)
    );
  }

  public function testFullStmt()
  {
    $query = QueryBuilder::select(AllSelectExpression::create())
      ->from(TableSelectExpression::createWithAlias('table_one', 't1'))
      ->join(TableSelectExpression::create('table_two'), 'myfield');

    $this->assertEquals(
      'SELECT * FROM table_one AS t1 INNER JOIN table_two ON t1.myfield = table_two.myfield',
      QueryAssembler::stringify($query)
    );
  }

  public function testInnerFullStmt()
  {
    $query = QueryBuilder::select(AllSelectExpression::create())
      ->from(TableSelectExpression::createWithAlias('table_one', 't1'))
      ->innerJoin(TableSelectExpression::create('table_two'), 'myfield');

    $this->assertEquals(
      'SELECT * FROM table_one AS t1 INNER JOIN table_two ON t1.myfield = table_two.myfield',
      QueryAssembler::stringify($query)
    );
  }

  public function testRightFullStmt()
  {
    $query = QueryBuilder::select(AllSelectExpression::create())
      ->from(TableSelectExpression::createWithAlias('table_one', 't1'))
      ->rightOuterJoin(TableSelectExpression::create('table_two'), 'myfield');

    $this->assertEquals(
      'SELECT * FROM table_one AS t1 RIGHT OUTER JOIN table_two ON t1.myfield = table_two.myfield',
      QueryAssembler::stringify($query)
    );
  }

  public function testLeftFullStmt()
  {
    $query = QueryBuilder::select(AllSelectExpression::create())
      ->from(TableSelectExpression::createWithAlias('table_one', 't1'))
      ->leftOuterJoin(TableSelectExpression::create('table_two'), 'myfield');

    $this->assertEquals(
      'SELECT * FROM table_one AS t1 LEFT OUTER JOIN table_two ON t1.myfield = table_two.myfield',
      QueryAssembler::stringify($query)
    );
  }

  /**
   * @expectedException \RuntimeException
   * @expectedExceptionMessage No predicates specified for join
   */
  public function testNoPredicates()
  {
    $class = new FinalJoinTrait();
    $class->addClause((new FromClause())->setTable('tbl'));
    $class->joinWithPredicates('tbl2');
  }

  /**
   * @expectedException \RuntimeException
   * @expectedExceptionMessage Unable to join on a statement without a from
   *                           clause being specified
   */
  public function testException()
  {
    $class = new FinalJoinTrait();
    $class->join('tbl', 'email');
  }
}

class FinalJoinTrait extends AbstractStatement
{
  use JoinTrait;

  protected function _getOrder()
  {
    return ["FROM", 'INNERJOIN'];
  }
}
