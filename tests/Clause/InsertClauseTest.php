<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\InsertClause;
use Packaged\QueryBuilder\Expression\FieldExpression;

class InsertClauseTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $clause = new InsertClause();
    $clause->setTable('tester');
    $this->assertEquals(
      'INSERT INTO tester ()',
      QueryAssembler::stringify($clause)
    );

    $clause->addField((new FieldExpression())->setField('id'));
    $this->assertEquals(
      'INSERT INTO tester (id)',
      QueryAssembler::stringify($clause)
    );
  }

  public function testGettersAndSetters()
  {
    $clause    = new InsertClause();
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

    $this->expectException("InvalidArgumentException");
    $clause->setFields([$nameField, $idField, 'abc']);
  }
}
