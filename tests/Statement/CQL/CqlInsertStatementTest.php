<?php
namespace Packaged\Tests\QueryBuilder\Statement\CQL;

use Packaged\QueryBuilder\Assembler\CQL\CqlAssembler;
use Packaged\QueryBuilder\Builder\CQL\CqlQueryBuilder;

class CqlInsertStatementTest extends \PHPUnit\Framework\TestCase
{
  public function testInsert()
  {
    $stmt = CqlQueryBuilder::insertInto('tbl', 'field1', 'field2')
      ->values('value1', 'value2');
    $this->assertEquals(
      'INSERT INTO "tbl" ("field1", "field2") VALUES (\'value1\', \'value2\')',
      CqlAssembler::stringify($stmt)
    );

    $assembler = new CqlAssembler($stmt);
    $this->assertEquals(
      'INSERT INTO "tbl" ("field1", "field2") VALUES (?, ?)',
      $assembler->getQuery()
    );
    $this->assertEquals(['value1', 'value2'], $assembler->getParameters());
  }

  public function testInsertTtl()
  {
    $stmt = CqlQueryBuilder::insertInto('tbl', 'field1', 'field2')
      ->values('value1', 'value2')
      ->usingTtl(50);
    $this->assertEquals(
      'INSERT INTO "tbl" ("field1", "field2") VALUES (\'value1\', \'value2\') USING TTL 50',
      CqlAssembler::stringify($stmt)
    );

    $assembler = new CqlAssembler($stmt);
    $this->assertEquals(
      'INSERT INTO "tbl" ("field1", "field2") VALUES (?, ?) USING TTL ?',
      $assembler->getQuery()
    );
    $this->assertEquals(['value1', 'value2', 50], $assembler->getParameters());
  }

  public function testInsertTimestamp()
  {
    $stmt = CqlQueryBuilder::insertInto('tbl', 'field1', 'field2')
      ->values('value1', 'value2')
      ->usingTimestamp(50);
    $this->assertEquals(
      'INSERT INTO "tbl" ("field1", "field2") VALUES (\'value1\', \'value2\') USING TIMESTAMP 50',
      CqlAssembler::stringify($stmt)
    );

    $assembler = new CqlAssembler($stmt);
    $this->assertEquals(
      'INSERT INTO "tbl" ("field1", "field2") VALUES (?, ?) USING TIMESTAMP ?',
      $assembler->getQuery()
    );
    $this->assertEquals(['value1', 'value2', 50], $assembler->getParameters());
  }

  public function testInsertTtlTimestamp()
  {
    $stmt = CqlQueryBuilder::insertInto('tbl', 'field1', 'field2')
      ->values('value1', 'value2')
      ->usingTtl(50)
      ->usingTimestamp(123456);
    $this->assertEquals(
      'INSERT INTO "tbl" ("field1", "field2") VALUES (\'value1\', \'value2\') USING TTL 50 AND TIMESTAMP 123456',
      CqlAssembler::stringify($stmt)
    );

    $assembler = new CqlAssembler($stmt);
    $this->assertEquals(
      'INSERT INTO "tbl" ("field1", "field2") VALUES (?, ?) USING TTL ? AND TIMESTAMP ?',
      $assembler->getQuery()
    );
    $this->assertEquals(
      ['value1', 'value2', 50, 123456],
      $assembler->getParameters()
    );
  }
}
