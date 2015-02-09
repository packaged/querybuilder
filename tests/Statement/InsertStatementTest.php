<?php
namespace Packaged\Tests\QueryBuilder\Statement;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\IncrementExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;

class InsertStatementTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $statement = QueryBuilder::insertInto('tbl');
    $this->assertEquals(
      'INSERT INTO tbl ()',
      QueryAssembler::stringify($statement)
    );

    $statement = QueryBuilder::insertInto('tbl', 'field');
    $this->assertEquals(
      'INSERT INTO tbl (field)',
      QueryAssembler::stringify($statement)
    );

    $statement->insertInto('tbl', FieldExpression::create('id'), 'name');

    $this->assertEquals(
      'INSERT INTO tbl (id, name)',
      QueryAssembler::stringify($statement)
    );

    $statement->values(null, ValueExpression::create('Test'));
    $this->assertEquals(
      'INSERT INTO tbl (id, name) '
      . 'VALUES (NULL, "Test")',
      QueryAssembler::stringify($statement)
    );

    $statement->values('row2v1', 'row2v2');
    $this->assertEquals(
      'INSERT INTO tbl (id, name) '
      . 'VALUES (NULL, "Test"), ("row2v1", "row2v2")',
      QueryAssembler::stringify($statement)
    );

    $statement = QueryBuilder::insertInto('tbl', 'field1', 'field2')
      ->values('value1', 'value2')
      ->onDuplicate('field1', IncrementExpression::create('field2', 1));
    $assembler = new QueryAssembler($statement);
    $this->assertEquals(
      'INSERT INTO tbl (field1, field2) VALUES (?, ?) ON DUPLICATE KEY UPDATE field1 = field2 + ?',
      $assembler->getQuery()
    );
    $this->assertEquals(['value1', 'value2', 1], $assembler->getParameters());
  }
}
