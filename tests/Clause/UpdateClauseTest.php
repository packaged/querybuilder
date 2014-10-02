<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Clause\UpdateClause;

class UpdateClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new UpdateClause();
    $clause->setTableName('tester');
    $this->assertEquals('UPDATE tester', $clause->assemble());
  }
}
