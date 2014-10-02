<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Clause\GroupByClause;
use Packaged\QueryBuilder\Expression\FieldExpression;

class GroupByClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new GroupByClause();
    $clause->addField((new FieldExpression())->setField('first'));
    $this->assertEquals('GROUP BY first', $clause->assemble());
  }
}
