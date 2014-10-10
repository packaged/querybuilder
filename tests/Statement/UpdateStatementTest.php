<?php
namespace Packaged\Tests\QueryBuilder\Statement;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\SetClause;
use Packaged\QueryBuilder\Clause\UpdateClause;
use Packaged\QueryBuilder\Clause\WhereClause;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Predicate\LikePredicate;
use Packaged\QueryBuilder\Predicate\NotEqualPredicate;
use Packaged\QueryBuilder\Statement\UpdateStatement;

class UpdateStatementTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $statement = new UpdateStatement();

    $update = new UpdateClause();
    $update->setTable(TableExpression::create('tbl'));
    $statement->addClause($update);
    $this->assertEquals('UPDATE tbl', QueryAssembler::stringify($statement));

    $where = new WhereClause();
    $where->addPredicate((new NotEqualPredicate())->setField('username'));
    $statement->addClause($where);
    $this->assertEquals(
      'UPDATE tbl WHERE username IS NOT NULL',
      QueryAssembler::stringify($statement)
    );

    $set = new SetClause();
    $set->addPredicate(
      (new EqualPredicate())->setField('username')->setExpression(
        (new StringExpression())->setValue('john')
      )
    );
    $statement->addClause($set);

    $where->addPredicate(
      (new LikePredicate())->setField('name')->setExpression(
        (new StringExpression())->setValue('Joh%')
      )
    );
    $this->assertEquals(
      'UPDATE tbl SET username = "john" '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%"',
      QueryAssembler::stringify($statement)
    );
  }
}
