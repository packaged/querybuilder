<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\LimitClause;

class LimitClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new LimitClause();
    $clause->setLimit(10);
    $this->assertEquals('LIMIT 10', QueryAssembler::stringify($clause));
    $clause->setOffset(5);
    $this->assertEquals('LIMIT 5,10', QueryAssembler::stringify($clause));
  }
}
