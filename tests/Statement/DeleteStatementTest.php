<?php
namespace Packaged\Tests\QueryBuilder\Statement;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\DeleteClause;
use Packaged\QueryBuilder\Clause\WhereClause;
use Packaged\QueryBuilder\Expression\Like\EndsWithExpression;
use Packaged\QueryBuilder\Predicate\LikePredicate;
use Packaged\QueryBuilder\Predicate\NotEqualPredicate;
use Packaged\QueryBuilder\Statement\DeleteStatement;

class DeleteStatementTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $statement = new DeleteStatement();

    $update = new DeleteClause();
    $update->setTable('tbl');
    $statement->addClause($update);
    $this->assertEquals(
      'DELETE FROM tbl',
      QueryAssembler::stringify($statement)
    );

    $where = new WhereClause();
    $where->addPredicate((new NotEqualPredicate())->setField('username'));
    $statement->addClause($where);
    $this->assertEquals(
      'DELETE FROM tbl WHERE username IS NOT NULL',
      QueryAssembler::stringify($statement)
    );

    $where->addPredicate(
      (new LikePredicate())->setField('name')->setExpression(
        EndsWithExpression::create('Joh')
      )
    );
    $this->assertEquals(
      'DELETE FROM tbl '
      . 'WHERE username IS NOT NULL AND name LIKE "%Joh"',
      QueryAssembler::stringify($statement)
    );
  }
}
