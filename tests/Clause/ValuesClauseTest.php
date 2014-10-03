<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Clause\ValuesClause;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;

class ValuesClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new ValuesClause();
    $this->assertEquals('VALUES ()', $clause->assemble());

    $clause->addExpression((new StringExpression())->setValue('one'));
    $this->assertEquals('VALUES ("one")', $clause->assemble());
    $clause->addExpression(new ValueExpression());
    $this->assertEquals('VALUES ("one", NULL)', $clause->assemble());

    $clause->clearExpressions();
    $this->assertEquals('VALUES ()', $clause->assemble());
  }

  public function testGettersAndSetters()
  {
    $clause = new ValuesClause();
    $field  = new StringExpression();
    $field->setValue('abc');
    $null = new ValueExpression();

    $this->assertFalse($clause->hasExpressions());
    $clause->addExpression($field);
    $this->assertTrue($clause->hasExpressions());
    $this->assertSame([$field], $clause->getExpressions());

    $clause->clearExpressions();
    $clause->setExpressions([$field, $null]);
    $this->assertTrue($clause->hasExpressions());

    $clause->clearExpressions();
    $this->assertFalse($clause->hasExpressions());

    $this->setExpectedException("InvalidArgumentException");
    $clause->setExpressions([$field, $null, 'abc']);
  }
}
