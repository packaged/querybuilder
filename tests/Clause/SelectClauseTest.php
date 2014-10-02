<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;
use Packaged\QueryBuilder\SelectExpression\NowSelectExpression;

class SelectClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new SelectClause();
    $this->assertEquals('SELECT *', $clause->assemble());

    $clause->addExpression((new FieldSelectExpression())->setField('one'));
    $this->assertEquals('SELECT one', $clause->assemble());
    $clause->addExpression(
      (new FieldSelectExpression())->setField('two')->setAlias('three')
    );
    $this->assertEquals('SELECT one, two AS three', $clause->assemble());

    $clause->clearExpressions();
    $clause->addExpression(new NowSelectExpression());
    $this->assertEquals('SELECT NOW()', $clause->assemble());
  }

  public function testGettersAndSetters()
  {
    $clause = new SelectClause();
    $field  = new FieldSelectExpression();
    $now    = new NowSelectExpression();

    $this->assertFalse($clause->hasExpressions());
    $clause->addExpression($field);
    $this->assertTrue($clause->hasExpressions());
    $this->assertSame([$field], $clause->getExpressions());

    $clause->clearExpressions();
    $clause->setExpressions([$field, $now]);
    $this->assertTrue($clause->hasExpressions());

    $clause->clearExpressions();
    $this->assertFalse($clause->hasExpressions());

    $this->setExpectedException("InvalidArgumentException");
    $clause->setExpressions([$field, $now, 'abc']);
  }
}