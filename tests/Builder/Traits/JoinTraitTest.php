<?php
namespace Packaged\Tests\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\Traits\JoinTrait;
use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Statement\AbstractStatement;

class JoinTraitTest extends \PHPUnit_Framework_TestCase
{
  public function testCreate()
  {
    $class = new FinalJoinTrait();
    $class->addClause((new FromClause())->setTableName('tbl'));
    $class->join('tbl2', 'email');
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
  }

  public function testException()
  {
    $class = new FinalJoinTrait();
    $this->setExpectedException(
      'RuntimeException',
      "Unable to join on a statement without a from clause being specified"
    );
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
