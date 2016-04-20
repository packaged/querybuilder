<?php
namespace Packaged\Tests\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\Traits\JoinTrait;
use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Statement\AbstractStatement;

class JoinTraitTest extends \PHPUnit_Framework_TestCase
{
  public function testCreate()
  {
    $class = new FinalJoinTrait();
    $class->addClause((new FromClause())->setTable('tbl'));
    $class->join(TableExpression::create('tbl2'), 'email');
    $this->assertEquals(
      "FROM tbl JOIN tbl2 ON tbl.email = tbl2.email",
      QueryAssembler::stringify($class)
    );
    $class->join('tbl3', 'user', 'user_id');
    $this->assertEquals(
      'FROM tbl JOIN tbl2 ON tbl.email = tbl2.email '
      . 'JOIN tbl3 ON tbl.user = tbl3.user_id',
      QueryAssembler::stringify($class)
    );
    $class->joinWithPredicates(
      'tbl4',
      EqualPredicate::create(
        FieldExpression::createWithTable('email', 'tbl2'),
        FieldExpression::createWithTable('email', 'tbl4')
      )
    );
    $this->assertEquals(
      'FROM tbl JOIN tbl2 ON tbl.email = tbl2.email '
      . 'JOIN tbl3 ON tbl.user = tbl3.user_id '
      . 'JOIN tbl4 ON tbl2.email = tbl4.email',
      QueryAssembler::stringify($class)
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
    return ["FROM", 'JOIN'];
  }
}
