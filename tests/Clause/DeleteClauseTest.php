<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\DeleteClause;

class DeleteClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new DeleteClause();
    $clause->setTable('tester');
    $this->assertEquals(
      'DELETE FROM tester',
      QueryAssembler::stringify($clause)
    );
  }
}
