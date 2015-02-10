<?php
namespace Packaged\Tests\QueryBuilder\Statement\CQL;

use Packaged\QueryBuilder\Assembler\CQL\CqlAssembler;
use Packaged\QueryBuilder\Builder\CQL\CqlQueryBuilder;

class CqlUpdateStatementTest extends \PHPUnit_Framework_TestCase
{
  public function testUpdate()
  {
    $stmt = CqlQueryBuilder::update('tbl', ['field1' => 'value1']);
    $this->assertEquals(
      'UPDATE "tbl" SET "field1" = \'value1\'',
      CqlAssembler::stringify($stmt)
    );

    $assembler = new CqlAssembler($stmt);
    $this->assertEquals(
      'UPDATE "tbl" SET "field1" = ?',
      $assembler->getQuery()
    );
    $this->assertEquals(['value1'], $assembler->getParameters());
  }

  public function testUpdateTtl()
  {
    $stmt = CqlQueryBuilder::update('tbl', ['field1' => 'value1'])
      ->usingTtl(50);
    $this->assertEquals(
      'UPDATE "tbl" USING TTL 50 SET "field1" = \'value1\'',
      CqlAssembler::stringify($stmt)
    );

    $assembler = new CqlAssembler($stmt);
    $this->assertEquals(
      'UPDATE "tbl" USING TTL ? SET "field1" = ?',
      $assembler->getQuery()
    );
    $this->assertEquals([50, 'value1'], $assembler->getParameters());
  }

  public function testUpdateTimestamp()
  {
    $stmt = CqlQueryBuilder::update('tbl', ['field1' => 'value1'])
      ->usingTimestamp(123456);
    $this->assertEquals(
      'UPDATE "tbl" USING TIMESTAMP 123456 SET "field1" = \'value1\'',
      CqlAssembler::stringify($stmt)
    );

    $assembler = new CqlAssembler($stmt);
    $this->assertEquals(
      'UPDATE "tbl" USING TIMESTAMP ? SET "field1" = ?',
      $assembler->getQuery()
    );
    $this->assertEquals([123456, 'value1'], $assembler->getParameters());
  }

  public function testUpdateTtlTimestamp()
  {
    $stmt = CqlQueryBuilder::update('tbl', ['field1' => 'value1'])
      ->usingTtl(50)
      ->usingTimestamp(123456);
    $this->assertEquals(
      'UPDATE "tbl" USING TTL 50 AND TIMESTAMP 123456 SET "field1" = \'value1\'',
      CqlAssembler::stringify($stmt)
    );

    $assembler = new CqlAssembler($stmt);
    $this->assertEquals(
      'UPDATE "tbl" USING TTL ? AND TIMESTAMP ? SET "field1" = ?',
      $assembler->getQuery()
    );
    $this->assertEquals([50, 123456, 'value1'], $assembler->getParameters());
  }
}
