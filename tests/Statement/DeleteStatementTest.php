<?php
namespace Packaged\Tests\QueryBuilder\Statement;

use Packaged\QueryBuilder\Clause\DeleteClause;
use Packaged\QueryBuilder\Clause\WhereClause;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\LikePredicate;
use Packaged\QueryBuilder\Predicate\NotEqualPredicate;
use Packaged\QueryBuilder\Statement\DeleteStatement;

class DeleteStatementTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $statement = new DeleteStatement();

    $update = new DeleteClause();
    $update->setTableName('tbl');
    $statement->addClause($update);
    $this->assertEquals('DELETE FROM tbl', $statement->assemble());

    $where = new WhereClause();
    $where->addPredicate((new NotEqualPredicate())->setField('username'));
    $statement->addClause($where);
    $this->assertEquals(
      'DELETE FROM tbl WHERE username IS NOT NULL',
      $statement->assemble()
    );

    $where->addPredicate(
      (new LikePredicate())->setField('name')->setExpression(
        (new StringExpression())->setValue('Joh%')
      )
    );
    $this->assertEquals(
      'DELETE FROM tbl '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%"',
      $statement->assemble()
    );
  }
}
