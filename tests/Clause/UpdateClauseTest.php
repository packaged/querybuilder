<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\UpdateClause;

class UpdateClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new UpdateClause();
    $clause->setTable('tester');
    $this->assertEquals('UPDATE tester', QueryAssembler::stringify($clause));
  }
}
