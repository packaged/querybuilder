<?php
namespace Packaged\Tests\QueryBuilder\Statement;

use Packaged\QueryBuilder\Clause\ReplaceClause;
use Packaged\QueryBuilder\Clause\ValuesClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\NullExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Statement\ReplaceStatement;

class ReplaceStatementTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $statement = new ReplaceStatement();

    $insert = new ReplaceClause();
    $insert->setTableName('tbl');
    $statement->addClause($insert);
    $this->assertEquals('REPLACE INTO tbl ()', $statement->assemble());

    $insert->addField((new FieldExpression())->setField('id'));
    $insert->addField((new FieldExpression())->setField('name'));

    $this->assertEquals('REPLACE INTO tbl (id, name)', $statement->assemble());

    $values = new ValuesClause();
    $values->addExpression(new NullExpression());
    $values->addExpression((new ValueExpression())->setValue("Test"));
    $statement->addClause($values);

    $this->assertEquals(
      'REPLACE INTO tbl (id, name) '
      . 'VALUES (NULL, "Test")',
      $statement->assemble()
    );
  }
}
