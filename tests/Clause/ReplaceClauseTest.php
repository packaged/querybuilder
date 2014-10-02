<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Clause\ReplaceClause;
use Packaged\QueryBuilder\Expression\FieldExpression;

class ReplaceClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new ReplaceClause();
    $clause->setTableName('tester');
    $this->assertEquals('REPLACE INTO tester ()', $clause->assemble());

    $clause->addField((new FieldExpression())->setField('id'));
    $this->assertEquals('REPLACE INTO tester (id)', $clause->assemble());
  }

  public function testGettersAndSetters()
  {
    $clause    = new ReplaceClause();
    $nameField = new FieldExpression();
    $nameField->setField('name');
    $idField = new FieldExpression();
    $idField->setField('id');

    $this->assertFalse($clause->hasFields());
    $clause->addField($nameField);
    $this->assertTrue($clause->hasFields());
    $this->assertSame([$nameField], $clause->getFields());

    $clause->clearFields();
    $clause->setFields([$nameField, $idField]);
    $this->assertTrue($clause->hasFields());

    $clause->clearFields();
    $this->assertFalse($clause->hasFields());

    $this->setExpectedException("InvalidArgumentException");
    $clause->setFields([$nameField, $idField, 'abc']);
  }
}
