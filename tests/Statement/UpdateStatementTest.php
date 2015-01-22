<?php
namespace Packaged\Tests\QueryBuilder\Statement;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\SetClause;
use Packaged\QueryBuilder\Clause\UpdateClause;
use Packaged\QueryBuilder\Clause\WhereClause;
use Packaged\QueryBuilder\Expression\Like\EndsWithExpression;
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

    $statement->update(TableExpression::create('tbl'));
    $this->assertEquals('UPDATE tbl', QueryAssembler::stringify($statement));

    $statement->where(['NOT' => ['username' => null]]);
    $this->assertEquals(
      'UPDATE tbl WHERE username IS NOT NULL',
      QueryAssembler::stringify($statement)
    );

    $statement->set('username', 'john');
    $statement->andWhere(
      (new LikePredicate())->setField('name')->setExpression(
        EndsWithExpression::create('Joh')
      )
    );
    $this->assertEquals(
      'UPDATE tbl SET username = "john" '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%"',
      QueryAssembler::stringify($statement)
    );
  }
}
