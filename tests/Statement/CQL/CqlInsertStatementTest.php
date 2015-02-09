<?php
namespace Packaged\Tests\QueryBuilder\Statement\CQL;

use Packaged\QueryBuilder\Assembler\CQL\CqlAssembler;
use Packaged\QueryBuilder\Builder\CQL\CqlQueryBuilder;

class CqlInsertStatementTest extends \PHPUnit_Framework_TestCase
{
  public function testInsert()
  {
    $stmt = CqlQueryBuilder::insertInto('tbl', 'field1', 'field2')
      ->values('value1', 'value2')
      ->usingTtl(50);
    $this->assertEquals(
      'INSERT INTO "tbl" ("field1", "field2") VALUES (\'value1\', \'value2\') USING TTL 50',
      CqlAssembler::stringify($stmt)
    );
  }
}
