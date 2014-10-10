<?php
namespace Packaged\Tests\QueryBuilder\Statement;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\ReplaceClause;
use Packaged\QueryBuilder\Clause\ValuesClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Statement\ReplaceStatement;

class ReplaceStatementTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $statement = new ReplaceStatement();

    $insert = new ReplaceClause();
    $insert->setTable('tbl');
    $statement->addClause($insert);
    $this->assertEquals(
      'REPLACE INTO tbl ()',
      QueryAssembler::stringify($statement)
    );

    $insert->addField((new FieldExpression())->setField('id'));
    $insert->addField((new FieldExpression())->setField('name'));

    $this->assertEquals(
      'REPLACE INTO tbl (id, name)',
      QueryAssembler::stringify($statement)
    );

    $values = new ValuesClause();
    $values->addExpression(new ValueExpression());
    $values->addExpression((new ValueExpression())->setValue("Test"));
    $statement->addClause($values);

    $this->assertEquals(
      'REPLACE INTO tbl (id, name) '
      . 'VALUES (NULL, "Test")',
      QueryAssembler::stringify($statement)
    );
  }
}
