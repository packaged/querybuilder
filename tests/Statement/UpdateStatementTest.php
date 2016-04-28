<?php
namespace Packaged\Tests\QueryBuilder\Statement;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Expression\Like\StartsWithExpression;
use Packaged\QueryBuilder\Predicate\LikePredicate;

class UpdateStatementTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $statement = QueryBuilder::update('tbl', ['field1' => 'value1']);
    $this->assertEquals(
      'UPDATE tbl SET field1 = "value1"',
      QueryAssembler::stringify($statement)
    );

    $statement->where(['NOT' => ['username' => null]]);
    $this->assertEquals(
      'UPDATE tbl SET field1 = "value1" WHERE username IS NOT NULL',
      QueryAssembler::stringify($statement)
    );

    $statement->set('username', 'john');

    $statement->andWhere(
      (new LikePredicate())->setField('name')->setExpression(
        StartsWithExpression::create('Joh')
      )
    );
    $this->assertEquals(
      'UPDATE tbl SET field1 = "value1", username = "john" '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%"',
      QueryAssembler::stringify($statement)
    );

    $statement->set('bob', null);
    $this->assertEquals(
      'UPDATE tbl SET field1 = "value1", username = "john", bob = NULL '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%"',
      QueryAssembler::stringify($statement)
    );

    $statement->orderBy(['username' => 'asc']);
    $this->assertEquals(
      'UPDATE tbl SET field1 = "value1", username = "john", bob = NULL '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%" ORDER BY username ASC',
      QueryAssembler::stringify($statement)
    );

    $statement->orderBy(['username' => 'desc', 'field1' => 'asc']);
    $this->assertEquals(
      'UPDATE tbl SET field1 = "value1", username = "john", bob = NULL '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%" '
      . 'ORDER BY username DESC, field1 ASC',
      QueryAssembler::stringify($statement)
    );

    $statement->limit(2);
    $this->assertEquals(
      'UPDATE tbl SET field1 = "value1", username = "john", bob = NULL '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%" '
      . 'ORDER BY username DESC, field1 ASC LIMIT 2',
      QueryAssembler::stringify($statement)
    );
  }
}
