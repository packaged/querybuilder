<?php
namespace Packaged\Tests\QueryBuilder\Statement;

use Packaged\QueryBuilder\Clause\InsertClause;
use Packaged\QueryBuilder\Clause\ValuesClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\NullExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Statement\InsertStatement;

class InsertStatementTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $statement = new InsertStatement();

    $insert = new InsertClause();
    $insert->setTableName('tbl');
    $statement->addClause($insert);
    $this->assertEquals('INSERT INTO tbl ()', $statement->assemble());

    $insert->addField((new FieldExpression())->setField('id'));
    $insert->addField((new FieldExpression())->setField('name'));

    $this->assertEquals('INSERT INTO tbl (id, name)', $statement->assemble());

    $values = new ValuesClause();
    $values->addExpression(new NullExpression());
    $values->addExpression((new ValueExpression())->setValue("Test"));
    $statement->addClause($values);

    $this->assertEquals(
      'INSERT INTO tbl (id, name) '
      . 'VALUES (NULL, "Test")',
      $statement->assemble()
    );
  }
}
