<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\GroupByClause;
use Packaged\QueryBuilder\Expression\FieldExpression;

class GroupByClauseTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $clause = new GroupByClause();
    $clause->addField((new FieldExpression())->setField('first'));
    $this->assertEquals('GROUP BY first', QueryAssembler::stringify($clause));
  }
}
