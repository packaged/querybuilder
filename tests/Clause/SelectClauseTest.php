<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;
use Packaged\QueryBuilder\SelectExpression\NowSelectExpression;

class SelectClauseTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $clause = new SelectClause();
    $this->assertEquals('SELECT *', QueryAssembler::stringify($clause));

    $clause->addExpression((new FieldSelectExpression())->setField('one'));
    $this->assertEquals('SELECT one', QueryAssembler::stringify($clause));
    $clause->addExpression(
      (new FieldSelectExpression())->setField('two')->setAlias('three')
    );
    $this->assertEquals(
      'SELECT one, two AS three',
      QueryAssembler::stringify($clause)
    );

    $clause->clearExpressions();
    $clause->addExpression(new NowSelectExpression());
    $this->assertEquals('SELECT NOW()', QueryAssembler::stringify($clause));

    $clause->clearExpressions();
    $clause->addField('first');
    $this->assertEquals('SELECT first', QueryAssembler::stringify($clause));

    $clause->clearExpressions();
    $clause->addField(FieldSelectExpression::create('first'));
    $this->assertEquals('SELECT first', QueryAssembler::stringify($clause));

    $clause->clearExpressions();
    $clause->addField(new NowSelectExpression());
    $this->assertEquals('SELECT NOW()', QueryAssembler::stringify($clause));

    $clause->clearExpressions();
    $clause->addField(['full_name' => ['first', '" "', 'last']]);
    $this->assertEquals(
      'SELECT CONCAT(first," ",last) AS full_name',
      QueryAssembler::stringify($clause)
    );

    $clause->clearExpressions();
    $clause->addTableField('tbl', 'first');
    $this->assertEquals('SELECT tbl.first', QueryAssembler::stringify($clause));

    $clause->clearExpressions();
    $clause->addTableField('tbl1', 'first');
    $clause->addTableField('tbl2', 'second');
    $this->assertEquals('SELECT tbl1.first, tbl2.second', QueryAssembler::stringify($clause));

    $clause->clearExpressions();
    $clause->addTableField('tbl', 'first', 'bob');
    $this->assertEquals('SELECT tbl.first AS bob', QueryAssembler::stringify($clause));

    $clause->clearExpressions();
    $clause->addTableFields('tbl', ['first', 'second', 'third']);
    $this->assertEquals('SELECT tbl.first, tbl.second, tbl.third', QueryAssembler::stringify($clause));

    $clause->clearExpressions();
    $clause->addField('first');
    $clause->setDistinct(true);
    $this->assertEquals(
      'SELECT DISTINCT first',
      QueryAssembler::stringify($clause)
    );

    $this->expectException("InvalidArgumentException");
    $clause->addField(new \stdClass());
  }

  public function testGettersAndSetters()
  {
    $clause = new SelectClause();
    $field = new FieldSelectExpression();
    $now = new NowSelectExpression();

    $this->assertFalse($clause->hasExpressions());
    $clause->addExpression($field);
    $this->assertTrue($clause->hasExpressions());
    $this->assertSame([$field], $clause->getExpressions());

    $clause->clearExpressions();
    $clause->setExpressions([$field, $now]);
    $this->assertTrue($clause->hasExpressions());

    $clause->clearExpressions();
    $this->assertFalse($clause->hasExpressions());

    $this->expectException("InvalidArgumentException");
    $clause->setExpressions([$field, $now, 'abc']);
  }

  public function testStatic()
  {
    $clause = SelectClause::create('first');
    $clause->setDistinct(true);
    $this->assertEquals('SELECT DISTINCT first', QueryAssembler::stringify($clause));

    $this->assertEquals('SELECT *', QueryAssembler::stringify(SelectClause::create()));
  }
}
