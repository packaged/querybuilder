<?php
namespace Packaged\Tests\QueryBuilder\Builder\Expect;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;

class QueryBuilderDeleteTest extends \PHPUnit_Framework_TestCase
{
  public function testDelete()
  {
    $query = QueryBuilder::deleteFrom('tablename', ['x' => 'y', 'a' => 'b']);

    $this->assertEquals(
      'DELETE FROM tablename WHERE x = "y" AND a = "b"',
      QueryAssembler::stringify($query)
    );
  }
}
