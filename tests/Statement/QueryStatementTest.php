<?php
namespace Packaged\Tests\QueryBuilder\Statement;

use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Clause\GroupByClause;
use Packaged\QueryBuilder\Clause\HavingClause;
use Packaged\QueryBuilder\Clause\OrderByClause;
use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\Clause\WhereClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\LessThanPredicate;
use Packaged\QueryBuilder\Predicate\LikePredicate;
use Packaged\QueryBuilder\Predicate\NotEqualPredicate;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;
use Packaged\QueryBuilder\Statement\QueryStatement;

class QueryStatementTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $statement = new QueryStatement();

    $select = new SelectClause();
    $select->addExpression(new AllSelectExpression());
    $statement->addClause($select);
    $this->assertEquals('SELECT *', $statement->assemble());

    $from = new FromClause();
    $from->setTableName('tbl');
    $statement->addClause($from);
    $this->assertEquals('SELECT * FROM tbl', $statement->assemble());

    $where = new WhereClause();
    $where->addPredicate((new NotEqualPredicate())->setField('username'));
    $statement->addClause($where);
    $this->assertEquals(
      'SELECT * FROM tbl WHERE username IS NOT NULL',
      $statement->assemble()
    );

    $where->addPredicate(
      (new LikePredicate())->setField('name')->setExpression(
        (new StringExpression())->setValue('Joh%')
      )
    );
    $this->assertEquals(
      'SELECT * FROM tbl '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%"',
      $statement->assemble()
    );

    $orderBy = new OrderByClause();
    $statement->addClause($orderBy);
    $orderBy->addField((new FieldExpression())->setField('user_id'));

    $this->assertEquals(
      'SELECT * FROM tbl '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%" '
      . 'ORDER BY user_id',
      $statement->assemble()
    );

    $orderBy->addField((new FieldExpression())->setField('age'), 'DESC');
    $this->assertEquals(
      'SELECT * FROM tbl '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%" '
      . 'ORDER BY user_id, age DESC',
      $statement->assemble()
    );

    $groupBy = new GroupByClause();
    $statement->addClause($groupBy);
    $groupBy->addField((new FieldExpression())->setField('role'));
    $this->assertEquals(
      'SELECT * FROM tbl '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%" '
      . 'GROUP BY role '
      . 'ORDER BY user_id, age DESC',
      $statement->assemble()
    );

    $having = new HavingClause();
    $statement->addClause($having);
    $having->addPredicate(
      (new LessThanPredicate())->setField('tasks')->setExpression(
        (new NumericExpression())->setValue(4)
      )
    );

    $this->assertEquals(
      'SELECT * FROM tbl '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%" '
      . 'GROUP BY role '
      . 'HAVING tasks < 4 '
      . 'ORDER BY user_id, age DESC',
      $statement->assemble()
    );
  }
}