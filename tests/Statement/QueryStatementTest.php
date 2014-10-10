<?php
namespace Packaged\Tests\QueryBuilder\Statement;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\FromClause;
use Packaged\QueryBuilder\Clause\GroupByClause;
use Packaged\QueryBuilder\Clause\HavingClause;
use Packaged\QueryBuilder\Clause\LimitClause;
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
    $this->assertEquals('SELECT *', QueryAssembler::stringify($statement));

    $from = new FromClause();
    $from->setTable('tbl');
    $statement->addClause($from);
    $this->assertEquals(
      'SELECT * FROM tbl',
      QueryAssembler::stringify($statement)
    );

    $where = new WhereClause();
    $where->addPredicate((new NotEqualPredicate())->setField('username'));
    $statement->addClause($where);
    $this->assertEquals(
      'SELECT * FROM tbl WHERE username IS NOT NULL',
      QueryAssembler::stringify($statement)
    );

    $where->addPredicate(
      (new LikePredicate())->setField('name')->setExpression(
        (new StringExpression())->setValue('Joh%')
      )
    );
    $this->assertEquals(
      'SELECT * FROM tbl '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%"',
      QueryAssembler::stringify($statement)
    );

    $orderBy = new OrderByClause();
    $statement->addClause($orderBy);
    $orderBy->addField((new FieldExpression())->setField('user_id'));

    $this->assertEquals(
      'SELECT * FROM tbl '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%" '
      . 'ORDER BY user_id',
      QueryAssembler::stringify($statement)
    );

    $orderBy->addField((new FieldExpression())->setField('age'), 'DESC');
    $this->assertEquals(
      'SELECT * FROM tbl '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%" '
      . 'ORDER BY user_id, age DESC',
      QueryAssembler::stringify($statement)
    );

    $groupBy = new GroupByClause();
    $statement->addClause($groupBy);
    $groupBy->addField((new FieldExpression())->setField('role'));
    $this->assertEquals(
      'SELECT * FROM tbl '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%" '
      . 'GROUP BY role '
      . 'ORDER BY user_id, age DESC',
      QueryAssembler::stringify($statement)
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
      QueryAssembler::stringify($statement)
    );

    $limit = new LimitClause();
    $limit->setLimit(10);
    $limit->setOffset(20);
    $statement->addClause($limit);

    $this->assertEquals(
      'SELECT * FROM tbl '
      . 'WHERE username IS NOT NULL AND name LIKE "Joh%" '
      . 'GROUP BY role '
      . 'HAVING tasks < 4 '
      . 'ORDER BY user_id, age DESC '
      . 'LIMIT 20,10',
      QueryAssembler::stringify($statement)
    );
  }
}
