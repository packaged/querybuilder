<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\FromClause;

class FromClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new FromClause();
    $clause->setTableName('tester');
    $this->assertEquals('FROM tester', QueryAssembler::stringify($clause));
  }
}
